<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionCategory extends TriggerCondition
	{
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
		public function run($combination,$product)
		{
			if ( strcmp($this->condition,'has') == 0 ) return $this->has((int)$combination,(int)$product);
				else return $this->hasNot((int)$combination,(int)$product);
		}
		/** True if this combination has this attribute */
		private function has($combination,$product)
		{
			if (Product::idIsOnCategoryId($product,$this->param))
				return true;
			else return false;
		}
		private function hasNot($combination,$product)
		{
			return !$this->has($combination,$product);
		}
	}
?>