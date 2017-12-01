<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	/* Conditions for Steps, see StepCondition for base class */
	include_once(__DIR__ .'/conditions/StepCondition.php');
	include_once(__DIR__ .'/conditions/StepConditionProduct.php');
	include_once(__DIR__ .'/conditions/StepConditionProductAttribute.php');
	include_once(__DIR__ .'/conditions/StepConditionProductAttributeGroup.php');	
	include_once(__DIR__ .'/conditions/StepConditionProductCategory.php');
	include_once(__DIR__ .'/conditions/StepConditionProductName.php');
	include_once(__DIR__ .'/conditions/StepConditionProductTag.php');	
	include_once(__DIR__ .'/actions/StepAction.php');
	include_once(__DIR__ .'/actions/StepActionCombination.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceAppendProductDetail.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceAppendDelete.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceAppendText.php');

	/**
	 *  Structure of a Step:
	 *  unserialize(step):
	 *  	id:
	 *  	position:
	 *  	conditions:
	 *  		unserialize(conditions)
	 *  	actions:
	 *  		unserialize(actions)
	 *
	 *  MEMO:
	 *  $this->save : Boolean to force save of each changes;
	 *  $this->recipe->save(): Function that saves changes on container recipe;
	 *  $this->moveAction($a,$newPos): Moves $a to $newPos and resort the tree;
	 *  $this->addAction($type,$action,$param,$lang)
	 *  $this->addCondition($type,$condition,$param,$lang)
	 *  $this->removeAction($microtime) $microtime is base Id
	 *  $this->removeCondition($microtime) Same as above
	 *  
	 */
	class Step
	{
		/** @var INT id_script, INT name_script, INT order position, (Container of this step) */
		public $recipe;	
		/** @var Starting by 0 */
		public $position;	
		public $id; /** One id, multiple positions */
		public $name;
		private $save;
		/* Array of heir objects */
		public $conditions = array();
		public $actions = array();
		/* Objects to be operated from Conditions, depending on context * Future work */
		public $product; /* Working int for Conditions and Actions */
		public $products; /* Array of input of $product to iterate*/
		public $product_combinations;		
		public $reference;
		public $references;
		public $ean13;
		public $ean13s;
		public $cart;
		public $carts;
		public $category;
		public $categories;
		public $tag;
		public $tags;
		public $client;
		public $clients;

		/* Bulk array var to input result for actions (based in)*/
		public $input = array();
		/* Bulk array var to output result for actions */
		public $output = array();


		public function __construct($type = null)
		{
			$this->id = microtime(true);			
		}
		/**
		 * [addCondition adds a Condition to this step]
		 * @param [type] $type      [StepConditionAttribute ....]
		 * @param [type] $condition [has,hasNot,match,left,right,left3,right3,...]
		 * @param [type] $param     [text param to match with condition]
		 * @param [type] $lang      [language id]
		 */
		public function addCondition($type,$condition,$param,$lang = null)
		{
			$init = array(
				'id' => microtime(true),
				'type' => $type,
				'condition' => $condition,
				'param' => $param,
				'lang' => $lang
			);
			$condition = new $type($init,$this);
			$this->conditions[] = $condition;
			if ($this->save) $this->recipe->save();
		}
		
		/**
		 * [removeCondition Removes a condition from this step bassed on its microtime]
		 * @param  [type] $microtime [description]
		 * @return [type]            [description]
		 */
		public function removeCondition($microtime)
		{
			foreach ($this->conditions as $key => $condition)	
			{
				if ($condition->getId() == $microtime)
				{
					unset($this->conditions[$key]);
					if ($this->save) $this->recipe->save();
				}
			}
		}
		/**
		 * [addAction adds an action to this step]
		 * @param [type] $type      [StepActionAppendText ....]
		 * @param [type] $action    [reference,price,ean13....]
		 * @param [type] $param     [text param to match with condition]
		 * @param [type] $lang      [language id]
		 */
		public function addAction($type,$action,$param,$lang = null)
		{
			$init = array(
				'id' => microtime(true),
				'type' => $type,
				'action' => $action,
				'param' => $param,
				'lang' => $lang
			);
			$action = new $type($init,$this);			
			//count(array(0,1,2) = 3)
			$this->actions[] = $action;
			if ($this->save) $this->recipe->save();
		}
		
		/**
		 * [moveAction Moves an action from position X to Y. All remaining actions positions switchs also]
		 * @param  [type] $oldPosition [0 or higher]
		 * @param  [type] $newPosition [0 or higher]
		 * @return [type]              [description]
		 */
		public function moveAction($oldPosition,$newPosition)
		{
			$diff = (int)($newPosition - $oldPosition);
			// Positive difference, newposition is bigger:
			// 0 => 5, so 1 will become 0, 2 => 1, 3 => 2, 4 => 3, 0 => 5
			// 
			// Negative, newposition is lower (Higher precedence)
			// 
			// Parameters in range?
			if ( !in_array($oldPosition,range(0,count($this->actions))) ||
					!in_array($newPosition,range(0,count($this->actions)))
				)			
				return false;
			$saved = $this->action[$oldPosition];
			foreach (range($oldPosition,$newPosition) as $position)
			{
				switch ($position)
				{
					case ($position < $newPosition):
						if ($oldPosition < $newPosition)
							$this->actions[$position] = $this->actions[$position+1];
						else
							$this->actions[$position] = $this->actions[$position-1];
						break;
					case $newPosition:
						$this->actions[$position] =  $saved;
						break;
				}
			}	
			if ($this->save) $this->recipe->save();					
		}

		/**
		 * [removeAction Removes an action from this step bassed on its microtime]
		 * @param  [type] $microtime [description]
		 * @return [type]            [description]
		 */
		public function removeAction($microtime)
		{
			foreach ($this->actions as $key => $actions)	
			{
				if ($action->getId() == $microtime)
				{
					unset($this->actions[$key]);
					foreach ($this->actions as $i => $ac)
					{
						if ($i > $key)
						{
							$this->actions[$i-1] = $this->actions[$i];
						}
					}					
					if ($this->save) $this->recipe->save();
				}
			}
		}

		/** [load Instead of a constructor, this helper class loads from an array its values] */
		public function load($t)
		{
			// If we have elements ...
			if (count($t) > 0)
			{
				foreach ($t as $key => $value)
				{
					switch ($key)
					{
					case 'id':
						$this->id = $value;
						break;
					case 'position':
						$this->position = $value;
						break;
					case 'actions':
						$this->actions = $value;
						break;
					case 'conditions':
						$this->conditions = $value;
						break;
					}
				}				
			}
		}
		/**
		 * [setProductToStep sets target of Step to one product id, useful for iterations]
		 * @param [type] $product [description]
		 */
		public function setProducts($products)
		{
			$this->products = $products;
			return $this;
		}

		/**
		 * [setProductCombinations Load product combinations for selected products]
		 * @param [array] $products [array of product ids (int), to be condensed on where clause]
		 */
		public function setProductCombinations($products)
		{
			$sql = new DBQuery();
			$sql->select('*');
			$sql->from('product_attribute','p');
			foreach ($products as $product)
			{
				$sql->where('id_product =' . $product);	
			}
			$sql->innerJoin('product_attribute_combination','pac','p.id_product_attribute = pa.id_product_attribute');	
			$r = Db::getInstance()->executeS($sql);
			if (count($r) > 0)
			{
				//We create an array of combinations, to perform changes on them from Actions later, by accessing them as $this->step->product_combinations[id_combination]
				foreach($r as $db_combination)
				{
					$n = new Combination($db_combination['id_product_attribute']);
					$this->product_combinations[$db_combination['id_product_attribute']] = $n;
				}
			}
			return $this;
		}
		/**
		 * [setSave AutoSave on edition]
		 * @param [type] $save [description]
		 */
		public function setSave($save)
		{
			$this->save = $save;
			return $this;
		}
		/**
		 * [runStep Runs step over selected product and provided string Reference]
		 * @param  [type] $reference [String we are creating]
		 */
		public function runStep()
		{
			/** We check if condition dependencies are right (product loaded, category, and so on) */
			foreach ($this->conditions as $i => $condition)
			{			
				if (!$condition->checkDependencies())
				{
					return false;
				}				
			}
			/* Dependencies ok, we run over conditions */
			foreach ($this->conditions as $i => $condition)
			{	
				/* On this way we start to work on future updates based on Addition of Conditions and Actions */
				$className = get_class($condition);
				if ( !call_user_func(array($className, 'iterator'), $step, $condition) )
						return false;
			}
			/* No false, so conditions are met, we try with Actions now */
			foreach ($this->actions as $i => $action)
			{	
				//On actions, we don't interrupt bucle, just check if dependencies are ok
				if ($action->checkDependencies())
				{
					/* Actions can perform an operation or create a return value in output */
					$className = get_class($action);
					call_user_func(array($className, 'iterator'), $step, $action);						
				}							
			}
			if ( count($this->output) > 0 )
				foreach ($this->output as $type => $output)
				{
					switch ($type)
					{
						case 'reference':
							
					}
				}				
			return true;
		}

	}
?>