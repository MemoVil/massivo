<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class TriggerConditionProductName extends TriggerCondition
	{
		public function __construct($init,$trigger)
		{
			parent::_construct($init,$trigger);
			$this->workOn = 'Product';
		}
		/**
		 * [$width Passed as $this->condition, user can select length of match on left of right compares]
		 * @var integer
		 */
		private $width = 1;
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
					$this->width = (int)str_replace('left','',$this->condition);
					return $this->left((int)$combination,(int)$product);
				//Or is "Not left1,left2..left3..."					
				case 1 == preg_match('/notleft\d+/',$this->condition):
					$this->width = (int)str_replace('left','',$this->condition);
					return !$this->left((int)$combination,(int)$product);
				//If condition is right1,right2,right3...(Or Not)
				case 1 == preg_match('/right\d+/',$this->condition):
					$this->width = (int)str_replace('right','',$this->condition);
					return $this->right((int)$combination,(int)$product);	
				case 1 == preg_match('/notright\d+/',$this->condition):
					$this->width = (int)str_replace('right','',$this->condition);
					return !$this->right((int)$combination,(int)$product);	
				case 'wildcard':
					return $this->wildcard((int)$combination,(int)$product);
			}
			
		}
		/** True if this combination has this attribute */
		private function match($combination,$product)
		{
			if (strcmp(Product::getProductName($product,$combination),$this->param,$this->lang) == 0 )
				return true;
			else return false;
		}

		private function left($combination,$product)
		{
			$productName = Product::getPRoductName($product,$combination,$this->lang);
			$pos = substr($productName,0,$this->width);
			/* lowing case to ensure match, perhaps a future modification */
			$match = strcmp(strtolower($pos),strtolower($this->param));
			return $match;
		}
		private function right($combination,$product)
		{
			$productName = Product::getPRoductName($product,$combination,$this->lang);
			$pos = substr($productName,-1*$this->width,$this->width);
			/* lowing case to ensure match, perhaps a future modification */
			$match = strcmp(strtolower($pos),strtolower($this->param));
			return $match;
		}
		private function wildcard($combination,$product)
		{
			$productName = Product::getPRoductName($product,$combination,$this->lang);
			// We want to make it dos like, so we replace this (in this order)...
			$to_replace = array('.','*','?');
			// With this...
			$replaced_by = array('\.','.','*');
			$t = str_replace($to_replace,$replaced_by,$this->param);			
			return preg_match('/' . $t .'/', $productName);
		}
	}
?>