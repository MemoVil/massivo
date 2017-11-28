<?php

	if (!defined('_PS_VERSION_'))
  		exit;

  	/**
  	 * Subclass to concatenate String at end of reference
  	 */
	class TriggerActionAppendText extends TriggerAction
	{
		public function run($reference)
		{
				$this->trigger->reference = $this->trigger->reference . $this->param;
		}
	}
?>