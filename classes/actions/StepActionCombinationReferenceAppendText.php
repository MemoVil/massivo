<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombinationReferenceAppendText extends StepActionCombination
	{		
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);
			$this->actionDescription = $this->l("Appends a text to its reference");
		}
		public function run()		
		{			
			$this->step->getProductCombinations($this->combination)->reference .=  $this->param;
		}		
	}
?>