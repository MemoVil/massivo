<?php
	if (!defined('_PS_VERSION_'))
  		exit;
  	class HelperMassivo extends ModuleAdminController
  	{      
  		public function __construct()
		  {
			  $this->bootstrap = true;
    		$this->colorOnBackground = true;
    		$this->row_hover = true;
    		$this->context = Context::GetContext();
		  }		 

      /**
       * [load Loads a template based on $type. It's a switcher to load tpls]
       * @param  [String] $type [TPL name]
       * @return [type]       [description]
       */
  		public function load($type,$params)
      {
        call_user_func(array($this,'display' . $type),$params);
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
        echo $tpl;
      }
  	}
?>
