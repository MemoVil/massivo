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
		 * Render scripts table on Create Tab (Select and Edit)
		 */
  		public function renderExistingScriptsTable($scripts)
  		{
  			if (!is_array($scripts))
  				return false;
  			$formatedScripts = array();
  			foreach ($scripts as $script)
  			{
  				$formatedScripts[] = array(
  					'id_script' => $script['id_script'],
  					'name' => $script['name']
  				);
  			}
  			$fields_form[0]['form'] = array(
       			'input' => array(
					array(
					  'type' => 'select',                              
					  'label' => $this->l('Select or create a new recipe:'),         					  
					  'name' => 'select_recipe',                     
					  'required' => true,                              
					  'options' => array(
					    'query' => $scripts,                           
					    'id' => 'id_script',                           
					    'name' => 'name'                               
					  )
					)       	
				)		 
       		);
			$helper = new HelperForm();
             // Module, token and currentIndex
            $helper->module = $this;
            $helper->name_controller = $this->name;
            $helper->token = Tools::getAdminTokenLite('AdminModules');
            $helper->currentIndex = AdminController::$currentIndex.'&configure='.$this->name;  
            // Language
            $helper->default_form_language = $lang;
            $helper->allow_employee_form_lang = $lang;
             
            // Title and toolbar
            $helper->title = $this->displayName;
            $helper->show_toolbar = true;        // false -> remove toolbar
            $helper->toolbar_scroll = true;      // yes - > Toolbar is always visible on the top of the screen.
            $helper->submit_action = 'arbol'.$this->name;
  
            $helper->tpl_vars = array(
                //'fields_value' => $scripts,
                'languages' => $this->context->controller->getLanguages(),
                'id_language' => $this->context->language->id
            );
    
            return $helper->generateForm($fields_form);
  		}

  	}
?>
