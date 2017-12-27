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
		public function getActionCreateModeJavascript($post)
		{
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/js/actions/stepActionCombinationReferenceAppendProductDetail.js.tpl');   
		}
		public function getActionCreationModeTemplate($post)
		{
			$this->context->smarty->assign('post',$post);
			$this->context->smarty->assign('time',$post['time']);
			$this->context->smarty->assign('features',Feature::getFeatures($this->lang));
			$this->context->smarty->assign('aid',$this->id);
			$this->context->smarty->assign('action',$this);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/actions/stepActionCombinationReferenceAppendProductDetail.tpl');   
		}
	}
?>