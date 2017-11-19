<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	/**
	 * Skeleton for nested Condition types
	 */
	class TriggerCondition
	{
		/** @var [id] [Unique id of this condition] */
		private $id;
		/** @var [type] [TriggerConditionType.php] */
		private $type;
		/** @var [condition] [] */
		private $condition;
		private $param;

		public function __construct($init)
		{
			if (count($init) < 3)
				return false;
			$init = unserialize($init);
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->condition = $init['condition'];
			$this->param = $init['param'];
		}
		/**
		 * [check main method, used to return true or false on heirs of this class, must be overriden]
		 * @return [type] [description]
		 */
		public function run($combination,$product)
		{
			return $this;
		}
		public static function getType($blob)
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