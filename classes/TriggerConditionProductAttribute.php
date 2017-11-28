<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductAttribute extends TriggerCondition
	{
		public function __construct($init,$trigger)
		{
			parent::_construct($init,$trigger);
			$this->workOn = 'Product';
		}
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run($combination,$product)
		{
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($combination,$product);
				else return $this->hasNot($combination,$product);
		}
		/** True if this combination has this attribute */
		private function has($combination,$product)
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
		private function hasNot($combination,$product)
		{
			return !$this->has($combination,$product);
		}
	}
?>