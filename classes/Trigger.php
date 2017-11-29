<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	/* Conditions for Triggers, see TriggerCondition for base class */
	include_once(__DIR__ .'/TriggerCondition.php');
	include_once(__DIR__ .'/TriggerConditionProduct.php');
	include_once(__DIR__ .'/TriggerConditionProductAttribute.php');
	include_once(__DIR__ .'/TriggerConditionProductAttributeGroup.php');	
	include_once(__DIR__ .'/TriggerConditionProductCategory.php');
	include_once(__DIR__ .'/TriggerConditionProductName.php');
	include_once(__DIR__ .'/TriggerConditionProductTag.php');	
	include_once(__DIR__ .'/TriggerAction.php');
	include_once(__DIR__ .'/TriggerActionAppendText.php');

	/**
	 *  Structure of a Trigger:
	 *  unserialize(trigger):
	 *  	id:
	 *  	position:
	 *  	conditions:
	 *  		unserialize(conditions)
	 *  	actions:
	 *  		unserialize(actions)
	 */
	class Trigger
	{
		/** @var INT id_script, INT name_script, INT order position, (Container of this trigger) */
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

		/* Bulk var to output result for actions */
		public $output;

		public function __construct()
		{
			$this->id = microtime(true);
		}
		/**
		 * [addCondition adds a Condition to this trigger]
		 * @param [type] $type      [TriggerConditionAttribute ....]
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
			if ($save) $this->recipe->save();
		}
		
		/**
		 * [removeCondition Removes a condition from this trigger bassed on its microtime]
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
					if ($save) $this->recipe->save();
				}
			}
		}
		/**
		 * [addAction adds an action to this trigger]
		 * @param [type] $type      [TriggerActionAppendText ....]
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
			$this->actions[] = $action;
			if ($save) $this->recipe->save();
		}
		
		/**
		 * [removeAction Removes an action from this trigger bassed on its microtime]
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
					if ($save) $this->recipe->save();
				}
			}
		}

		/** [load Instead of a constructor, this helper class loads from an array its values] */
		public function load($t)
		{
			// If we have elements ...
			if (count($t) > 0)
			{
				$this->id = (int)$t['id'];
				$this->position = (int)$t['position'];				
				$this->conditions = $t['conditions'];
				$this->actions = $t['actions'];
			}
		}
		/**
		 * [setProductToTrigger sets target of Trigger to one product id, useful for iterations]
		 * @param [type] $product [description]
		 */
		public function setProducts($products)
		{
			$this->products = (int)$products;
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
				$this->product_combinations = $r;
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
		 * [runTrigger Runs trigger over selected product and provided string Reference]
		 * @param  [type] $reference [String we are creating]
		 */
		public function runTrigger()
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
				$className = get_class($condition);
				if ( !call_user_func(array($className, 'iterator'), $trigger, $condition) )
						return false;
				/*
				switch ($condition->worksOn)
				{
					case 'ProductCombination':
						foreach($this->product_combinations as $combination)
						{
							$condition->combination = $combination;
							if (!$condition->run())
								return false;
						}
						break;
					case 'Product':
						foreach($this->products as $product)
						{
							$this->product = $product;
							if (!$condition->run())
								return false;
						}
						break;
				}		*/			
			}
			/* No false, so conditions are met, we try with Actions now */
			foreach ($this->actions as $i => $action)
			{			
				if (!$action->checkDependencies())
				{
					return false;
				}				
			}
	
		}

	}
?>