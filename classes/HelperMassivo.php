<?php
	if (!defined('_PS_VERSION_'))
  		exit;
    class HelperMassivo 
  	{      
  		public function __construct()
		  {
			  $this->bootstrap = true;
    		$this->colorOnBackground = true;
    		$this->row_hover = true;
        $this->context = Context::getContext();  
		  }		 

      /**
       * [load Loads a template based on $type. It's a switcher to load tpls]
       * @param  [String] $type [TPL name]
       * @return [type]       [description]
       */
  		public function load($type,$params)
      {
        return call_user_func(array($this,'display' . $type),$params);
      }
      /**
       * [displayCreateTabStepsForm Renders Steps Form on CreateTab]
       * @param  [type] $recipe [description]
       * @return [type]         [description]
       */
      public function displayCreateTabStepsForm($recipe)
      {        
        //Steps is an array of objects Step
        $steps = $recipe->getAllSteps();
        $massivoKey = Configuration::get('massivo_key');                
        $this->context->smarty->assign(
          array(
            'recipe' => $recipe,
            'steps' => $steps,
            'module_dir' => _MODULE_DIR_,
            'massivo_key' => $massivoKey                  
          )
        );        
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayCreateTabStepsForm.tpl');                                
        return $tpl;
      }

      public function displayNewConditionSelector($post)      
      {

        $r = Recipe::load($post['recipeid']);
        $massivoKey = Configuration::get('massivo_key');                
        $s = $r->getStepById($post['step']);             
        //ddd($s->deleteModels());           
        $this->context->smarty->assign(array(
          //Object recipe
          'recipe' => $r,
          //Step itself, not id
          'step' => $s,
          //Condition id, to know which row we are editing
          'condition' =>  (int) $post['param'] ,
          'massivo_key' => $massivoKey
        ));
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionSelector.tpl');                                        
        return $tpl;
      }
  	}
?>
