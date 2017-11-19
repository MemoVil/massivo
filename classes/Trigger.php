<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	/* Conditions for Triggers, see TriggerCondition for base class */
	include_once(__DIR__ .'/TriggerCondition.php');
	include_once(__DIR__ .'/TriggerConditionAttributeGroup.php');
	include_once(__DIR__ .'/TriggerConditionAttribute.php');
	include_once(__DIR__ .'/TriggerConditionCategory.php');
	include_once(__DIR__ .'/TriggerConditionTag.php');
	include_once(__DIR__ .'/TriggerConditionName.php');
	include_once(__DIR__ .'/TriggerAction.php');
	include_once(__DIR__ .'/TriggerActionAppendText.php');

	class Trigger
	{
		/** @var INT id_script, INT name_script, INT order position, (Container of this trigger) */
		public $id_script; 
		public $name_script; 
		public $position;	
		public $id; /** One id, multiple positions */
		public $conditions = array();
		public $actions = array();
		public $product;

		/** [load Instead of a constructor, this helper class loads from an array its values] */
		public function load($t)
		{
			// If we have elements ...
			if (count($t) > 0)
			{
				$this->id = (int)$t['id'];
				$this->position = (int)$t['position'];				
				$p = unserialize($t['conditions']);
				// We run through the array...
				foreach ($p as $i => $v)
				{
					//Each condition must have three basic fields:
					//
					//	1. Type (To select processing class)
					//	2. Condition itself (Equal, Not Equal, In, Not In)
					//	3. Param from user
					//	
					//	Conditions MUST return a boolean value
					//						
					$conditionType = TriggerCondition::getType($v);
					$condition = new $conditionType($v);
					$this->conditions[] = $condition;
				}
				$p = unserialize($t['actions']);
				foreach ($p as $i => $v)
				{
					//Each condition must have three basic fields:
					//
					//	1. Type (To select processing class)
					//	2. Condition itself (Equal, Not Equal, In, Not In)
					//	3. Param from user
					//	
					//	Conditions MUST return a boolean value
					//						
					$actionType = TriggerAction::getType($v);
					$action = new $actionType($v);
					$this->actions[] = $condition;
				}
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
		 * [runTrigger Runs trigger over selected product and provided string Reference]
		 * @param  [type] $reference [String we are creating]
		 */
		public function runTrigger($reference)
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
					$reference = $action->run($reference);
				}
			}
		}

	}
?>