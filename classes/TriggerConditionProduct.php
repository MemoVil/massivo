<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	/**
	 * Skeleton for nested Condition types
	 */
	class TriggerConditionProduct extends TriggerCondition
	{
		public function checkDependencies()
		{
			if (isset($this->trigger->products) )
				return true;
			return false;
		}
		//Override
		public static function iterator($trigger,$condition)
		{
			foreach($trigger->products as $product)
			{
				$trigger->product = $product;
				if (!$condition->run())
					return false;
			}
			return true;
		}
	}
?>