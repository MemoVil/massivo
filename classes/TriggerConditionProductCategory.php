<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductCategory extends TriggerConditionProduct
	{	
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run()	
		{			
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->trigger->product);
				else return $this->hasNot($this->trigger->product);
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