<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombination extends StepAction
	{
		public $combination;	
		public $lock = array('product','product_combination');	
		public static function iterator($step,$action)
		{
			foreach($step->getProductCombinations() as $combination => $comb)
			{
				$action->combination = $combination;
				$action->run();
					
			}
			return true;
		}
	}
?>