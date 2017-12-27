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
			$this->actionDescription = array(
				'short_description' => $this->l("Appends a product data to its reference"),
				'long_description' => $this->l("Appends related product data to its reference")
			);
		}
		public function run()		
		{
			$param = '';			
			switch ($this->action)
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
		/* Fake Override */
		public function getScript($post)
		{
			$this->context->smarty->assign(
				array(
					'post' => $post,
					'time' => $post['time'],
					'features' => Feature::getFeatures($this->lang),
					'aid' => $this->id,
					'action' => $this
				)
			);			
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/classes/js/stepActionCombinationReferenceAppendProductDetail.js.tpl');   
			return $tpl;
		}
		/* Fake Override */
		public function displayActionCreateMode($post)
		{			
			$this->context->smarty->assign(
				array(
					'post' => $post,
					'time' => $post['time'],
					'features' => Feature::getFeatures($this->lang),
					'aid' => $this->id,
					'action' => $this
				)
			);			
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/classes/actions/templates/stepActionCombinationReferenceAppendProductDetail.tpl');   
			ddd($tpl);
			return $tpl;
		}
	}
?>