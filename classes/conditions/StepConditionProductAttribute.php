<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductAttribute extends StepCondition
	{
		public $combination;
		public function __construct($init,$step)
		{
			parent::_construct($init,$step);
			$this->workOn = 'ProductCombination';
		}
		public function checkDependencies()
		{
			if (count($this->step->product_combinations) > 0)
				return true;
			return false;
		}
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()				
		{
			parent::run();
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
		/* Iterator for combinations, we need to use both product and combination values */
		public static function iterator($step,$condition)
		{
			foreach($step->getProductCombinations() as $combination => $comb)
			{
				$condition->combination = $combination;
				if (!$condition->run())
					return false;
			}
			return true;
		}
	}
?>