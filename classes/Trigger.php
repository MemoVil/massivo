<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	/* Conditions for Triggers, see TriggerCondition for base class */
	include_once(__DIR__ .'/TriggerCondition.php');
	include_once(__DIR__ .'/TriggerConditionProductAttributeGroup.php');
	include_once(__DIR__ .'/TriggerConditionProductAttribute.php');
	include_once(__DIR__ .'/TriggerConditionProductCategory.php');
	include_once(__DIR__ .'/TriggerConditionProductTag.php');
	include_once(__DIR__ .'/TriggerConditionProductName.php');
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
		public $product;		
		public $reference;
		public $ean13;
		public $cart;
		public $category;
		public $tag;
		public $client;

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
		public function setProduct($product)
		{
			$this->product = (int)$product;
			return $this;
		}
		/**
		 * [setSave AutoSave on edition]
		 * @param [type] $save [description]
		 */
		public function setSave($save)
		{
			$this->save = $save;
		}
		/**
		 * [runTrigger Runs trigger over selected product and provided string Reference]
		 * @param  [type] $reference [String we are creating]
		 */
		public function runTrigger()
		{
			$sql = new DBQuery();
			$sql->select('*');
			$sql->from('product_attribute','p');
			$sql->where('id_product =' . $this->product);	
			$sql->innerJoin('product_attribute_combination','pac','p.id_product_attribute = pa.id_product_attribute');	
			$r = Db::getInstance()->executeS($sql);
			//We want to perform changes for each combination of each product
			foreach ($r as $row)
			{
				foreach ($this->conditions as $i => $condition)
				{					
					/** One of the conditions fail */
					if ( !$condition->run($row['id_product_attribute'])) 
						return $this;
				}
				foreach ($this->actions as $i => $action)
				{
					/** We perform changes one by one */
					$action->run(Product);
				}
			}
		}

	}
?>