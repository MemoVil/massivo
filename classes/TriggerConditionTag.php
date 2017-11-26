<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionTag extends TriggerCondition
	{
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
		private function hasNot($combination,$product)
		{
			return !$this->has($combination,$product);
		}
	}
?>