<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductTag extends StepConditionProduct
	{		
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);			
			$this->conditionDescription = array(
				"long_description_left" => $this->l("If selected product(s)"),
				"long_description_right" => $this->l("tag "),
				"short_description" => $this->l("Product tag match")
			);
			$this->verbConditionDescription = array(
				"has" => $this->l(" has "),
				"hasNot" => $this->l(" hasn't ")
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
			if ( strcmp($this->condition,'has') == 0 ) return $this->has($this->step->product);
				else return $this->hasNot($this->step->product);
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