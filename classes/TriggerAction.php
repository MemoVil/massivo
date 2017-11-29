<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	class TriggerAction
  	{
  		private $id;
		/** @var [type] [TriggerActionType.php] */
		private $type;
		/** @var [action] [] */
		private $action;
		/**
		 * [$position Actions MUST have a precedence order, just in case]
		 * @var [type]
		 */
		private $position;
		private $param;
		public $trigger;
		public $worksOn;

		public function __construct($init,$trigger)
		{
			if (count($init) < 3)
				return false;
			$init = unserialize($init);
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->action = $init['action'];
			$this->param = $init['param'];
			$this->trigger = $trigger;
		}
		/**
		 * [run runs action and return new reference, to be overloaded]
		 * @param  [String] $reference [new string we are creating]		 
		 */
		public function run($reference)
		{
			return $this;
		}
		/**
		 * [update Updates params on action, even type]
		 * @param  [type] $init [description]
		 * @return [type]       [description]
		 */
		public function update($init)
		{
			$this->type = $init['type'];
			$this->action = $init['action'];
			$this->param = $init['param'];
		}
		/**
		 * [getType returns class name for run operation]
		 * @param  [type] $blob [description]
		 * @return [type]       [description]
		 */
		public function getType($blob)
		{
			$d = unserialize($blob);
			return $d['type'];
		}

		public function getId()
		{
			return $this->id;
		}
  	}
 ?>