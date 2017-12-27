<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	
  	class StepAction 
  	{
  		use scription;
  		public $id;
		/** @var [type] [StepActionType.php] */
		private $type;
		/** @var [action] [] */
		private $action;
		public $lang;
		/**
		 * [$position Actions MUST have a precedence order, just in case, in parent step]
		 * @var [type]
		 */		
		private $param;
		public $step;
		/* Array of elements for inputs that get info from Store */
		public $selectable = array();
		// Actions must be unlocked by conditions, so actions that handle products can only be performed if there is a matching condition to unlock it
		public $lock = array();
		public $actionDescription = array();		
		public $verbActionDescription = array();

		public function __construct($step, $init = null)
		{
			if ( !$init )
				$init = array(
					"id" => $this->getTime(),
					"type" => get_class($this),
					"action" => '',
					"param" => ''
			);						
			
			$this->id = $init['id'];
			$this->type = $init['type'];
			$this->action = $init['action'];
			$this->param = $init['param'];			
			$this->step = $step;
			$this->selectable = $this->getSelectable();
			if (array_key_exists('lang',$init))
			{
				$this->lang = $init['lang'];
				
			}
			else $this->lang = Context::getContext()->language->id;		
		}
		public function checkDependencies()
		{
			return false;
		}
		/**
		 * [run runs action and return new reference, to be overloaded]
		 * @param  [String] $reference [new string we are creating]		 
		 */
		public function run()
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
			$this->action = $init['action'];
			$this->param = $init['param'];
		}
		/**
		 * [getType returns class name for run operation]
		 * @param  [type] $blob [description]
		 * @return [type]       [description]
		 */
		public static function getType($action)
		{			
			return $action['type'];
		}

		public function getId()
		{
			return $this->id;
		}
		public static function iterator($step,$action)
		{
			return;
		}
		public function getText()
 		{
 			return $this->actionDescription['short_description'];
 		}
 		public function getDescription()
 		{
 			return $this->getText();	
 		}
 		public function getVerb($human = null)
 		{
 			if ($human == null)
 				return $this->verbActionDescription;
 			else if ($t = array_search($human,$this->getVerb()))
 				return $t;
 			else return false;
 		}
 		public function getLongText()
 		{
 			$this->actionDescription['long_description'];
 		} 		
 		
 		// For advanced handling of templates for some specific actions
 		public function getActionCreateModeTemplate($post)
 		{
 			return false;
 		}
		public function l($string, $specific = false){
 			return Translate::getModuleTranslation(Module::getInstanceByName('massivo'), $string, ($specific) ? $specific : 'massivo');
 		}
 		
 		
 		public function getSelectable()
 		{
 			return false;
 		}
 		
  	}
 ?>