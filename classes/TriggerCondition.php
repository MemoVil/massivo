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
		private $lang;
		public $trigger;
		/* Restriction::Info that Trigger should apport to TriggerCondition 
			IE: product,cart,reference,ean13,category,client. 

			Determined by each ConditionType.
		*/
		public $worksOn;

		public function __construct($init,$trigger)
		{
			if (count($init) < 3)
				return false;			
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->condition = $init['condition'];
			$this->param = $init['param'];
			$this->lang = $init['lang'] ? $init['lang'] : Context::getContext()->language->id;
			$this->trigger = $trigger;
		}
		public function setParam($param)
		{
			$this->param = $param;
			return $this;
		}
		public function setCondition($conditionDetail)
		{
			$this->condition = $conditionDetail;
			return $this;
		}
		public function setLang($lang)
		{
			$this->lang = $lang;
		}
		/**
		 * [check main method, used to return true or false on heirs of this class, must be overriden]
		 * @return [type] [description]
		 */
		public function run()
		{
			return $this;
		}
		public static function getType($condition)
		{		
			return $condition['type'];
		}
		public function getId()
		{
			return $this->id;
		}
		
		/* Saving using Trigger save method */
		public function save()
		{
			$this->trigger->save();
			return $this;
		}
		/**
		 * Allow us to iterate based on TriggerCondition specific needs
		 */
		public static function iterator($trigger,$condition)
		{
			return false;
		}
		public function checkDependencies()
		{
			return false;
		}
	}
?>