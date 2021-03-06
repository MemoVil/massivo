<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	/**
	 * Skeleton for nested Condition types
	 */
	class StepConditionProduct extends StepCondition
	{
		public $key = array('product');
		public function __construct($step, $init = null)
		{
			parent::__construct($step, $init);
			$this->workOn ="Product";
		}
		public function run()
		{
			parent::run();
		}
		public function checkDependencies()
		{
			if (isset($this->step->recipe->products) )
				return true;
			return false;
		}
		//Override
		public static function iterator($step,$condition)
		{
			foreach($step->getProducts() as $product)
			{
				$step->product = $product;
				if (!$condition->run())
					return false;
			}
			return true;
		}
	}
?>