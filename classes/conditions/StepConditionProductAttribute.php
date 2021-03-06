<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductAttribute extends StepCondition
	{
		public $combination;	
		public $key = array('product','product_combination');
		
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);
			$this->worksOn = 'ProductCombination';
			$this->conditionDescription = array(
				"long_description_left" => $this->l("If selected product(s) combination"),
				"long_description_right" => $this->l("attribute "),
				"short_description" => $this->l("Attribute match")
			);
			$this->verbConditionDescription = array(
				"has" => $this->l(" has "),
				"hasNot" => $this->l(" hasn't ")
			);
			$this->selectable = $this->getAttributeData();			
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
		public function getAttributeData()
		{		
			$r = array();	
			foreach ( Attribute::getAttributes($this->lang) as $attribute) 
			{
				$public = '[' . $attribute['public_name'] . '] ' . $attribute['name'];
				$s = array(
					'public' => $public,
					'id' => $attribute['id_attribute']
				);
				$r[] = $s;
			}			
			return $r;
		}

	}
?>