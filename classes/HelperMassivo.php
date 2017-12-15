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
      /**
       * [displayNewConditionSelector Displays combo box for condition table within step row on Recipe Editor]
       * @param  [type] $post [description]
       * @return [tpl]
       */
      public function displayNewConditionSelector($post)      
      {

        $r = Recipe::load($post['recipeid']);
        $massivoKey = Configuration::get('massivo_key');                
        $s = $r->getStepById($post['stepid']);             
        //ddd($s->deleteModels());           
        $this->context->smarty->assign(array(
          //Object recipe
          'recipe' => $r,
          //Step itself, not id
          'step' => $s,
          //Condition id, to know which row we are editing
          'condition' =>  (int) $post['param'] ,
          'massivo_key' => $massivoKey,
          'module_dir' => _MODULE_DIR_
        ));
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionSelector.tpl');                                        
        return $tpl;
      }

      public function displayConditionInput($class,$post)
      {
        $massivoKey = Configuration::get('massivo_key');                
        $r = Recipe::load($post['recipeid']);
        $s = $r->getStepById($post['stepid']);             
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'row' => $post['condition'],
            'module_dir' => _MODULE_DIR_,
            'massivo_key' => $massivoKey,
            'condition' => $class
          )
        );                
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionInput.tpl');        
        return $tpl;
      }
      /**
       * [displayAddBlankStep Adds a new step to Steplist]
       * @param  [type] $recipe [description]
       * @param  [type] $step   [description]
       * @return [type]         [description]
       */
      public function displayAddBlankStep($recipe, $step)
      {
        $r = $recipe; $s = $step;   
        $massivoKey = Configuration::get('massivo_key');                     
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'massivo_key' => $massivoKey,
            'pos' => $r->getStepPosition($s),
            'module_dir' => _MODULE_DIR_
          )
        );
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayAddBlankStep.tpl');        
        return $tpl;
      }
      /**
       * [displayAddedCondition Show new condition and adds a blank new condition below it]
       * @param  [type] $post [description]
       * @return [type]       [description]
       */
      public function displayAddedCondition($post)
      {
        $r = Recipe::load($post['recipeid']);
        $s = $r->getStepById($post['stepid']);    
        $massivoKey = Configuration::get('massivo_key');                     
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'massivo_key' => $massivoKey,
            'cpos' => $post['condition'],
            'condition' => $post['conditionObject']
          )
        );
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayAddedCondition.tpl');        
        return $tpl;
      }
  	}
?>
