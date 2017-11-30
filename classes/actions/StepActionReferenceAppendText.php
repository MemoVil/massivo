<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class StepActionReferenceAppendText extends StepAction
	{
		public $combination;

		public function run()
		{
				$this->step->output['reference'][$combination][] =  $this->param;
		}
		public function checkDependencies()
		{
			return true;
		}
		public static function iterator($step,$action)
		{
			foreach($step->product_combinations as $combination)
			{
				$action->combination = $combination;
				$action->run();
					
			}
			return true;
		}
	}
?>