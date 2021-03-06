<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	/* Conditions for Steps, see StepCondition for base class */
  	/* Important, they must be registered on step constructor */
  	/* Hardcoded includes, must be loaded first */
  	include_once(__DIR__ .'/../includes/scription.php');
	include_once(__DIR__ .'/StepCondition.php');
	include_once(__DIR__ .'/conditions/StepConditionProduct.php');
	include_once(__DIR__ .'/conditions/StepConditionProductAttribute.php');
	include_once(__DIR__ .'/conditions/StepConditionProductAttributeGroup.php');	
	include_once(__DIR__ .'/conditions/StepConditionProductCategory.php');
	include_once(__DIR__ .'/conditions/StepConditionProductName.php');
	include_once(__DIR__ .'/conditions/StepConditionProductTag.php');	
	include_once(__DIR__ .'/StepAction.php');
	include_once(__DIR__ .'/actions/StepActionCombination.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceAppendProductDetail.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceDelete.php');
	include_once(__DIR__ .'/actions/StepActionCombinationReferenceAppendText.php');
	/* include_once, ONCE ... */
	foreach (glob(__DIR__ . '/conditions/*.php') as $filename)
	{
    	include_once $filename;
	}
	foreach (glob(__DIR__. '/actions/*.php') as $filename)
	{
    	include_once $filename;
	}

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
		use scription;
		/** @var INT id_script, INT name_script, INT order position, (Container of this step) */
		public $recipe;	
		
		public $id; /** One id, multiple positions */
		public $name;
		private $save;
		/* Array of heir objects */
		public $conditions = array();
		public $actions = array();
		/* To be operated from Conditions, depending on context * Future work */
		public $product;
		/* Deprecated, moved to Recipe class */
		/**
		 * [$declaredClasses Classes loaded on this file: conditions and actions]
		 * @var [type]
		 */
		public $declaredConditions;
		public $declaredActions;

		/**
		 * [__construct variable constructor]
		 * It will set variables for this step on the form key => object, eg:
		 *  $s = new Step(
		 *  		array(
		 *  			'product' => $products,
		 *  			'a' => $client)
		 *  			), 
		 *  		array(...) 
		 *   On this way we can make a push of arrays for inputs on Steps (Future feature)
		 */
		public function __construct()
		{
			$this->id = $this->getTime();	
			$this->registerConditionsAndActions();	
			$args = func_get_args();				
			foreach($args as $arg)	{
				foreach ($arg as $key => $val)
				{
					$this->$key = $val;
				}
			}
		}
		/*
			Important: We need to register them to bucle over it later *
		 */
		public function registerConditionsAndActions()
		{
			$t = get_declared_classes();
			foreach ($t as $class)
			{		
				if (strpos($class,'Condition')  )
					$this->declaredConditions[] = $class;
				if (strpos($class,'Action'))
					$this->declaredActions[] = $class;
			}
			$this->deleteModels();
		}
		public function deleteModels()
		{				
			if ( array_search('StepCondition',$this->declaredConditions) >= 0)
				unset($this->declaredConditions[array_search('StepCondition',$this->declaredConditions)]);
			if ( array_search('StepAction',$this->declaredActions) >= 0)
				unset($this->declaredActions[array_search('StepAction',$this->declaredActions)]);
			return true;			
		}
		public function getDeclaredConditions()
		{
			return $this->declaredConditions;
		}
		public function getDeclaredActions()
		{
			return $this->declaredActions;
		}
		/* Input for combos */
		public function getConditionText($i)
		{
			if ($this->declaredConditions[$i])
			{
				$c = new $this->declaredConditions[$i]($this);
				return $c->getText();
			}
			return false;			 
		}
		public function getAllConditionsText()
		{
			$r = Array();
			foreach ($this->declaredConditions as $declared)
			{
				$c = new $declared($this);
				if ( $c->getText() ) 
					$r[$declared] = $c->getText();
			}
			return $r;
		}
		
		public function getCondition($condition)
		{
			if (count($this->conditions) > $condition)
				return $this->conditions[$condition];
		}
		public function getConditionById($id)
		{	
			foreach ( $this->conditions as $condition ) {
				if ( strcmp($condition->getId(),$id) == 0)
				{					
					return $condition;				
				}
			}
			return false;
		}
		public function findCondition($c)
		{
			foreach ($this->conditions as $order => $condition)
			{
				if ($condition->getId() == $c->getId() )
					return $order;
			}
			return false;
		}
		public function getActionText($i)
		{
			if ($this->declaredActions[$i])
			{
				$c = new $this->declaredActions[$i]($this);
				return $c->getText();
			}
			return false;			 
		}
		public function getActionById($id)
		{	
			foreach ( $this->actions as $action ) {
				if ( strcmp($action->getId(),$id) == 0)
				{					
					return $action;				
				}
			}
			return false;
		}
		//Actions must NOT be returned if dependencies are not met
		public function getAllActionsText()
		{
			$r = Array();
			foreach ($this->declaredActions as $declared)
			{
				$valid = false;
				$a = new $declared($this);
				foreach ($this->conditions as $condition)
				{
					if (array_intersect($a->lock, $condition->key))
						$valid = true;
				}
				if ( $valid && $a->getText() ) 
					$r[$declared] = $a->getText();
			}
			return $r;
		}
		// Returns array of unlocked actions
		public function getUnlockedActions()
		{		
 			$valid = array();
 			if (count($this->conditions) > 0)
 			{
 				foreach ($this->conditions as $condition)
				{
					foreach($this->declaredActions as $action)
						{
						$action = new $action($this);
						if (array_intersect($action->lock, $condition->key))
							$valid[] = $action;
						}
				}				
 			}
 			return $valid;
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
			$condition = new $type($this,$init);
			$this->conditions[] = $condition;
			if ($this->save) $this->recipe->save();
			return $condition;
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
					$toDelete = $key;
				}
			}
			if (isset($toDelete))
			{
				if ($toDelete == (count($this->conditions) - 1) )
				{				
					unset($this->conditions[$toDelete]);
					if ($this->save) $this->recipe->save();
					return true;
				}
				else
				{									
					foreach ($this->conditions as $i => $sc)
					{
						if ($i > $toDelete)
						{
							$this->conditions[$i-1] = $this->conditions[$i];
						}
					}					
					unset($this->conditions[count($this->conditions) - 1]);
					if ($this->save) $this->recipe->save();
					return true;
				}
			}
			return false;
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
			$action = new $type($this, $init);			
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
		 * [getProducts gets products on recipe]
		 * @return [array] [int]
		 */
		public function getProducts()
		{
			return $this->recipe->products;
		}
		public function getProductCombinations($id = null)
		{
			if ($id)
				return $this->recipe->product_combinations[$id];
			return $this->recipe->product_combinations;
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
			//If we have loaded product combinations we must save them after actions are performed all over the tree
			if (count($this->recipe->product_combinations))
			{
				foreach($this->getProductCombinations() as $i => $combination)
				{
					$combination->save();
				}
			}			
			return true;
		}

	}
?>