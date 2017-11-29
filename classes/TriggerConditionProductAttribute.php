<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductAttribute extends TriggerCondition
	{
		public $combination;
		public function __construct($init,$trigger)
		{
			parent::_construct($init,$trigger);
			$this->workOn = 'ProductCombination';
		}
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()		
		{
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->combination);
				else return $this->hasNot($this->combination);
		}
		/** True if this combination has this attribute */
		private function has($combination)
		{
			$sql = new DBQuery();
			$sql->select('*')
				->from('product_attribute_combinations','pac')
				->where('id_product_attribute =' . $combination . 'AND id_attribute=' . (int)$this->param);
			$r = Db::getInstance()->executeS($sql);
			if (count($r) > 0)
				return true;
			else return false;
		}
		private function hasNot($combination)
		{
			return !$this->has($combination);
		}
	}
?>