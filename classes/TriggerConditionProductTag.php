<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductTag extends TriggerConditionProduct
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
		public function run()
		{
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->trigger->product);
				else return $this->hasNot($this->trigger->product);
		}
		/** True if this product has this attribute */
		private function has($product)
		{
			$tags = Tag::getProductTags($product);
			$sucess = false;
			if (!in_array($this->lang, $tags))
				return false;
			foreach ($tags[$this->lang] as $k)
			{
				if (strcmp($k,$this->param) )
					$success = true;
			}
			return $success;			
		}
		private function hasNot($product)
		{
			return !$this->has($product);
		}
	}
?>