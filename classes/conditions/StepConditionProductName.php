<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class StepConditionProductName extends StepConditionProductAttribute
	{		
		public function __construct($init,$step)
		{
			parent::__construct($init,$step);
			$this->conditionDescription = array(
				"long_description_left" => $this->l("If selected product(s) combination name "),
				"long_description_right" => $this->l(""),
				"short_description" => $this->l("Product name match")
			);
			$this->verbConditionDescription = array(
				"match" => $this->l(" matches "),
				"notMatch" => $this->l(" doesn't match "),
				"left1" => $this->l(" has first char on left equal to "),
				"left2" => $this->l(" has first two chars on left equal to "),
				"left3" => $this->l(" has first three chars on left equal to "),
				"left4" => $this->l(" has first four chars on left equal to "),
				"left5" => $this->l(" has first five chars on left equal to "),
				"left6" => $this->l(" has first six chars on left equal to "),
				"left7" => $this->l(" has first seven chars on left equal to "),
				"left8" => $this->l(" has first eight chars on left equal to "),
				"left9" => $this->l(" has first nine chars on left equal to "),
				"left10" => $this->l(" has first ten chars on left equal to "),
				"left11" => $this->l(" has first eleven chars on left equal to "),
				"left12" => $this->l(" has first twelve chars on left equal to "),
				"right1" => $this->l(" has first char on right equal to "),
				"right2" => $this->l(" has first two chars on right equal to "),
				"right3" => $this->l(" has first three chars on right equal to "),
				"right4" => $this->l(" has first four chars on right equal to "),
				"right5" => $this->l(" has first five chars on right equal to "),
				"right6" => $this->l(" has first six chars on right equal to "),
				"right7" => $this->l(" has first seven chars on right equal to "),
				"right8" => $this->l(" has first eight chars on right equal to "),
				"right9" => $this->l(" has first nine chars on right equal to "),
				"right10" => $this->l(" has first ten chars on right equal to "),
				"right11" => $this->l(" has first eleven chars on right equal to "),
				"right12" => $this->l(" has first twelve chars on right equal to "),
				"notLeft1" => $this->l(" hasn't first char on left equal to "),
				"notLeft2" => $this->l(" hasn't first two chars on left equal to "),
				"notLeft3" => $this->l(" hasn't first three chars on left equal to "),
				"notLeft4" => $this->l(" hasn't first four chars on left equal to "),
				"notLeft5" => $this->l(" hasn't first five chars on left equal to "),
				"notLeft6" => $this->l(" hasn't first six chars on left equal to "),
				"notLeft7" => $this->l(" hasn't first seven chars on left equal to "),
				"notLeft8" => $this->l(" hasn't first eight chars on left equal to "),
				"notLeft9" => $this->l(" hasn't first nine chars on left equal to "),
				"notLeft10" => $this->l(" hasn't first ten chars on left equal to "),
				"notLeft11" => $this->l(" hasn't first eleven chars on left equal to "),
				"notLeft12" => $this->l(" hasn't first twelve chars on left equal to "),
				"notRight1" => $this->l(" hasn't first char on right equal to "),
				"notRight2" => $this->l(" hasn't first two chars on right equal to "),
				"notRight3" => $this->l(" hasn't first three chars on right equal to "),
				"notRight4" => $this->l(" hasn't first four chars on right equal to "),
				"notRight5" => $this->l(" hasn't first five chars on right equal to "),
				"notRight6" => $this->l(" hasn't first six chars on right equal to "),
				"notRight7" => $this->l(" hasn't first seven chars on right equal to "),
				"notRight8" => $this->l(" hasn't first eight chars on right equal to "),
				"notRight9" => $this->l(" hasn't first nine chars on right equal to "),
				"notRight10" => $this->l(" hasn't first ten chars on right equal to "),
				"notRight11" => $this->l(" hasn't first eleven chars on right equal to "),
				"notRight12" => $this->l(" hasn't first twelve chars on right equal to "),
				"wildcard" => $this->l(" wildcards with ")
			);	
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
		
		public function run()
		{
			parent::run();
			$product = $this->step->product;
			switch ($this->condition)
			{
				case 'match':
					return $this->match($this->combination,$this->step->product);
				case 'notMatch':
					return !$this->match($this->combination,$this->step->product);
				//If condition is left1,left4,left5...
				case 1 == preg_match('/Left\d+/',$this->condition):
					$this->width = (int)str_replace('left','',$this->condition);
					return $this->left($this->combination,$this->step->product);
				//Or is "Not left1,left2..left3..."					
				case 1 == preg_match('/notLeft\d+/',$this->condition):
					$this->width = (int)str_replace('left','',$this->condition);
					return !$this->left($this->combination,$this->step->product);
				//If condition is right1,right2,right3...(Or Not)
				case 1 == preg_match('/right\d+/',$this->condition):
					$this->width = (int)str_replace('right','',$this->condition);
					return $this->right($this->combination,$this->step->product);	
				case 1 == preg_match('/notRight\d+/',$this->condition):
					$this->width = (int)str_replace('right','',$this->condition);
					return !$this->right($this->combination,$this->step->product);	
				case 'wildcard':
					return $this->wildcard($this->combination,$this->step->product);
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