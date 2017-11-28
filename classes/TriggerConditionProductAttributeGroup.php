<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductAttributeGroup extends TriggerCondition
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
				else return $this->notHas($combination,$product);
		}
		/** True if this combination has this group */
		private function has($combination,$product)
		{
			$sql = new DBQuery();
			$sql->select('id_attribute_group')
				->from('product_attribute_combinations','pac')
				->where('id_product_attribute =' . $combination)
				->innerJoin('attribute','a','a.id_attribute = pac.id_attribute');
			$r = Db::getInstance()->executeS($sql);
			if (count($r) > 0)
				return true;
			else return false;
		}
		private function notHas($combination,$product)
		{
			return !$this->has($combination,$product);
		}
	}
?>