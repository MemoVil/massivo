<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	/**
	 * Skeleton for nested Condition types
	 */
	class StepCondition
	{
		/** @var [id] [Unique id of this condition] */
		private $id;
		/** @var [type] [StepConditionType.php] */
		private $type;
		/** @var [condition] [] */
		private $condition;
		private $param;
		private $lang;
		public $step;
		/* Restriction::Info that Step should apport to StepCondition 
			IE: product,cart,reference,ean13,category,client. 

			Determined by each ConditionType.
		*/
		public $worksOn;

		public function __construct($init,$step)
		{
			if (count($init) < 3)
				return false;			
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->condition = $init['condition'];
			$this->param = $init['param'];
			$this->lang = $init['lang'] ? $init['lang'] : Context::getContext()->language->id;
			$this->step = $step;
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
		
		/* Saving using Step save method */
		public function save()
		{
			$this->step->save();
			return $this;
		}
		/**
		 * Allow us to iterate based on StepCondition specific needs
		 */
		public static function iterator($step,$condition)
		{
			return false;
		}
		public function checkDependencies()
		{
			return false;
		}
	}
?>