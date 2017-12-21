<?php
	if (!defined('_PS_VERSION_'))
  		exit;
    class HelperMassivo 
  	{      
      public $massivo;
  		public function __construct()
		  {
			  $this->bootstrap = true;
    		$this->colorOnBackground = true;
    		$this->row_hover = true;
        $this->context = Context::getContext();  
        $this->massivo = Configuration::get('massivo_key'); 
        $this->context->smarty->assign(
          array(
          'massivo_key' => $this->massivo,
          'module_dir' =>  _MODULE_DIR_
          )
        ); 
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
        $this->context->smarty->assign(
          array(
            'recipe' => $recipe,
            'steps' => $steps              
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
        $s = $r->getStepById($post['stepid']);             
        //ddd($s->deleteModels());           
        $this->context->smarty->assign(array(
          //Object recipe
          'recipe' => $r,
          //Step itself, not id
          'step' => $s,
          //Condition id, to know which row we are editing
          'condition' =>  (int) $post['param']        
        ));
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionSelector.tpl');                                        
        return $tpl;
      }

      public function displayConditionInput($class,$post)
      {                       
        $r = Recipe::load($post['recipeid']);
        $s = $r->getStepById($post['stepid']);             
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'row' => $post['condition'],
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
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,            
            'pos' => $r->getStepPosition($s)
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
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,            
            'cpos' => $post['condition'],
            'condition' => $post['conditionObject']
          )
        );
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayAddedCondition.tpl');        
        return $tpl;
      }
      /**
       * [displayExistingCondition Replace base definition with editor mode]
       * @param  [type] $post [description]
       * @return [type]       [description]
       */
      public function displayExistingCondition($post)
      {
        $r = Recipe::load($post['recipe']);
        $s = $r->getStepById($post['step']);         
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'cpos' => $post['condition'],
            'condition' => $post['conditionObject']             
          )
        );
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayExistingCondition.tpl');        
        return $tpl;
      }
      public function displayRestoreCondition($post)
      {
        $r = Recipe::load($post['recipeid']);
        $s = $r->getStepById($post['stepid']);         
        $c = $s->getCondition($post['condition']);
        $this->context->smarty->assign(
          array(
            'recipe' => $r,
            'step' => $s,
            'cpos' => $post['condition'],
            'condition' => $c
          )
        );
        $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayRestoreCondition.tpl');       
        return $tpl;
      }
      /**
       * New section, clearfix
       */
      
      public function displayConditionPressHereMode($post)
      {
          $r = Recipe::load($post['recipe']);
          $s = $r->getStepById($post['step']);          
          $this->context->smarty->assign(
            array(
              'recipe' => $r,
              'step' => $s,
              'row' => $post['row']              
            )
          );
          $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionPressHereMode.tpl');
          return $tpl;
      }

      public function displayConditionTextMode($post)
      {
          $r = Recipe::load($post['recipe']);
          $s = $r->getStepById($post['step']);
          $c = $s->getCondition($post['row']);                  
          $this->context->smarty->assign(
                  array(
                    'recipe' => $r,
                    'step' => $s,  
                    'row' => $post['row'],
                    'condition' => $c
                  )
          );   
          $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionTextMode.tpl');
          return $tpl;
      }
      /**
       * [displayCreateMode Display row on first creation, which is showed via ajax $time  calls (one component one ajax)]
       * @param  [type] $post [description]
       * @return [type]       [description]
       */
      public function displayConditionCreateMode($post)
      {
          $r = Recipe::load($post['recipe']);
          $s = $r->getStepById($post['step']);                  
          $this->context->smarty->assign(
                  array(
                    'recipe' => $r,
                    'step' => $s,  
                    'row' => $post['row']
                  )
          );  
          if (array_key_exists('condition',$post))          
              $this->context->smarty->assign('condition',$post['condition']);            
          switch ($post['time'])
          {
            case 'start':
                $this->context->smarty->assign('time','start');
                $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/displayConditionCreateMode.tpl');       
            break;
            //Both verb and param are triggered via jquery.load function
            case 'verb':
              $this->context->smarty->assign('time','verb');              
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionVerb.tpl');       
            break;
            case 'param':                 
              $this->context->smarty->assign('time','param');
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionParam.tpl');       
            break;
            case 'buttons':
              $this->context->smarty->assign('time','buttons');              
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionButtons.tpl');       
            break;
            case 'type':
              $this->context->smarty->assign('time','type');              
               $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionType.tpl');       
            break;
            case 'left':
              $this->context->smarty->assign('time','left');              
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionLeft.tpl');       
            break;
            case 'right':
              $this->context->smarty->assign('time','right');              
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionRight.tpl');       
            break;   
            case 'editbuttons':
              $this->context->smarty->assign('time','buttons');
              $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/params/displayConditionEditButtons.tpl');       
            break;         
          }        
       return $tpl;
      }
      /**
       * [getScript returns a script tag tpl for inclussion from $.getScript]
       * @param  [type] $this->post [description]
       * @return [type]             [description]
       */
      public function getScript($post)
      {
          $r = Recipe::load($post['recipe']);
          $s = $r->getStepById($post['step']);                            
          if ($post['condition'])            
            $this->context->smarty->assign('condition',$post['condition']);
          else if ($post['cid']){
            $c = $s->getConditionById($post['cid']);
            $this->context->smarty->assign('condition',$c);
          }
          if ($post['action'])
            $this->context->smarty->assign('action',$post['action']);
          $this->context->smarty->assign(
                  array(
                    'recipe' => $r,
                    'step' => $s,  
                    'row' => $post['row']
                  )
          );  
          $tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/helpers/js/' . $post['script'] . '.js.tpl');       
          return $tpl;
      }
  	}
?>
