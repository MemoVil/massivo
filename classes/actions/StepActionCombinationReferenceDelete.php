<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombinationReferenceDelete extends StepActionCombination
	{
		public function run()
		{
				$this->step->getProductCombinations($this->combination)->reference = null;
		}	
	}
?>