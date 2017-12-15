<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductCategory extends StepConditionProduct
	{			
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);
			$this->conditionDescription = array(
				"long_description_left" => $this->l("If selected product(s)"),
				"long_description_right" => $this->l("on category "),
				"short_description" => $this->l("Product category match")
			);
			$this->verbConditionDescription = array(
				"isLocated" => $this->l(" is located "),
				"isNotLocated" => $this->l(" isn't located ")
			);	
		}
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()	
		{			
			parent::run();
			if ( strcmp($this->condition,'isLocated') == 0 ) return $this->isLocated($this->step->product);
				else return $this->isNotLocated($this->step->product);
		}
		/** True if this product is in the category passed as param */
		private function isLocated($product)
		{
			if (Product::idIsOnCategoryId($product,$this->param))
				return true;
			else return false;
		}
		private function isNotLocated($product)
		{
			return !$this->isLocated($product);
		}
		public function paramInfo($id)
		{
			foreach ($this->getAttributeData() as $option)
			{
				if ($option['id'] == $id)
					return $option['public'];
			}
		}
	}
?>