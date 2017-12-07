<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombinationReferenceAppendText extends StepActionCombination
	{		
		public function __construct($init,$step)
		{
			parent::__construct($init,$step);
			$this->actionDescription = $this->l("Appends a text to its reference");
		}
		public function run()		
		{			
			$this->step->getProductCombinations($this->combination)->reference .=  $this->param;
		}		
	}
?>