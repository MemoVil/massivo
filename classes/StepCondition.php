<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	include_once(__DIR__ .'/../includes/scription.php');

	 /* Skeleton for nested Condition types
	 */
	class StepCondition
	{
		use scription;
		/** @var [id] [Unique id of this condition] */
		private $id;
		/** @var [type] [StepConditionType.php] */
		private $type;
		/** @var [condition] [] */
		private $condition;
		private $param;
		public $lang;
		public $step;
		/* Array of elements for inputs that get info from Store */
		public $selectable = array();
		//This is the way we will show user a description of how each Condition is showed. We must show two strings:
		//	1. Long description, to use on editor, like (If product combination) + verbDescription + (this attributes:) + param
		//	2. Short description, to use on popup/select		
		public $conditionDescription = array(
			"long_description_left" => "", "long_description_right" => "", "short_description" => ""
		);

		// Verb Condition Description is the action itself on condition. This could be has,has not, so we must use an array for this
		public $verbConditionDescription;

		/* Restriction::Info that Step should apport to StepCondition 
			IE: product,cart,reference,ean13,category,client. 

			Determined by each ConditionType.
		*/
		public $worksOn;

		//Creates a random and void condition linked to this step
		//This construct must be called knowing class of Condition
		public function __construct($step, $init = null)
		{
			if ( $init == null )
				$init = array(
					"id" => $this->getTime(),
					"type" => get_class($this),
					"condition" => '',
					"param" => ''
				);				
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->condition = $init['condition'];
			$this->param = $init['param'];

			if (array_key_exists('lang',$init))
			{
				$this->lang = $init['lang'];
				
			}
			else $this->lang = Context::getContext()->language->id;								
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
		public function getCondition()
		{
			return $this->condition;
		}
		public function getParam()
		{
			return $this->param;
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
		public function getFullDescription()
		{
			$return[] = $this->conditionDescription['long_description_left'];
			$return[] = $this->verbConditionDescription[$this->condition];
			$return[] = $this->conditionDescription['long_description_right'];
			$return[] = $this->paramInfo($this->param);
			return implode($return);
 		}
 		public function getText()
 		{
 			return $this->conditionDescription['short_description'];
 		} 		
 		public function getDescription()
 		{
 			return $this->getText();	
 		}
 		public function getLeftText()
 		{
 			return $this->conditionDescription['long_description_left'];
 		}
 		public function getRightText()
 		{
 			return $this->conditionDescription['long_description_right'];
 		}
 		public function getVerb($human = null)
 		{
 			if ($human == null)
 				return $this->verbConditionDescription;
 			else if ($t = array_search($human,$this->getVerb()))
 				return $t;
 			else return false;
 		}
 		public function getSelectable()
 		{
 			return $this->selectable;
 		}
 		public function paramInfo($id)
		{
			if (!count($this->getSelectable() > 0) )
				return $id;
			foreach ($this->getAttributeData() as $option)
			{
				if ($option['id'] == $id)
					return $option['public'];
			}
		}
		public function l($string, $specific = false){
 			return Translate::getModuleTranslation(Module::getInstanceByName('massivo'), $string, ($specific) ? $specific : 'massivo');
 		}
 		
 		
	}
?>