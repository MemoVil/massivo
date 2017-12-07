<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombinationReferenceDelete extends StepActionCombination
	{
		public function __construct($init,$step)
		{
			parent::__construct($init,$step);
			$this->actionDescription = $this->l("Reset it's reference to null");
		}
		public function run()
		{
				$this->step->getProductCombinations($this->combination)->reference = null;
		}	
	}
?>