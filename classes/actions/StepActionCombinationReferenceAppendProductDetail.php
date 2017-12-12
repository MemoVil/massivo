<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionCombinationReferenceAppendProductDetail extends StepActionCombination
	{		
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);
			$this->actionDescription = $this->l("Appends a product data to its reference");
		}
		public function run()		
		{
			$param = '';			
			switch ($this->param)
			{
				case '%product%':
					$param = $this->step->product_combinations[$this->combination]->id_product;
					break;
				case '%combination%':
					$param = $this->combination;
					break;				
			}
			$this->step->getProductCombinations($this->combination)->reference .=  $param;
		}	
	}
?>