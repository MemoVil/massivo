<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductCategory extends StepConditionProduct
	{	
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()	
		{			
			parent::run();
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->step->product);
				else return $this->hasNot($this->step->product);
		}
		/** True if this product is in the category passed as param */
		private function has($product)
		{
			if (Product::idIsOnCategoryId($product,$this->param))
				return true;
			else return false;
		}
		private function hasNot($product)
		{
			return !$this->has($product);
		}
	}
?>