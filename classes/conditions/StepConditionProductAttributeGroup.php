<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductAttributeGroup extends StepConditionProductAttribute
	{
	
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()
		{	
			parent::run();
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->combination);
				else return $this->notHas($this->combination);			
		}
		/** True if this combination has this group */
		private function has($combination)
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
		private function notHas($combination)
		{
			return !$this->has($combination);
		}
	}
?>