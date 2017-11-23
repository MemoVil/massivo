<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionName extends TriggerCondition
	{
		
		/**
		 * [run Override]
		 * 
		 * @return [boolean] [true or false]
		 */
	
		public function run($combination,$product)
		{
			switch ($this->condition)
			{
				case 'match':
					return $this->match((int)$combination,(int)$product);
				case 'notmatch':
					return !$this->match((int)$combination,(int)$product);
				//If condition is left1,left4,left5...
				case 1 == preg_match('/left\d+/',$this->condition):
					return $this->left((int)$combination,(int)$product);
				//Or is "Not left1,left2..left3..."					
				case 1 == preg_match('/notleft\d+/',$this->condition):
					return !$this->left((int)$combination,(int)$product);
				//If condition is right1,right2,right3...(Or Not)
				case 1 == preg_match('/right\d+/',$this->condition):
					return $this->right((int)$combination,(int)$product);	
				case 1 == preg_match('/notright\d+/',$this->condition):
					return !$this->right((int)$combination,(int)$product);	
				case 'wildcard':
					return $this->wildcard((int)$combination,(int)$product);
			}
			
		}
		/** True if this combination has this attribute */
		private function match($combination,$product)
		{
			if (strcmp(Product::getProductName($product,$combination),$this->param) == 0 )
				return true;
			else return false;
		}

		private function left($combination,$product)
		{

		}
		private function right($combination,$product)
		{

		}
		private function wildcard($combination,$product)
		{
			
		}
	}
?>