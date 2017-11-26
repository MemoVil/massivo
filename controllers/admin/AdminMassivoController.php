<?php  
	if (!defined('_PS_VERSION_'))
  		exit;
  	$include = _PS_MODULE_DIR_ . '/massivo/includes/scription.php';
  	include_once($include);
	class AdminMassivoController extends ModuleAdminController
	{
		use scription;
		public function __construct()
		{
			$this->table = 'product_attribute';
    		$this->className = 'ProductAttribute';
    		$this->page_header_toolbar_title = $this->l('Massivo');
    		$this->bootstrap = true;
    		$this->colorOnBackground = true;
    		$this->row_hover = true;
    		$this->addCSS(_PS_MODULE_DIR_ .'/massivo/css/AdminMassivoController.css');
    		$this->_select = "m.`canonic_product` as canonic_product";
    		$this->_join = 'LEFT JOIN `' . _DB_PREFIX_ . 'massivo` m ON (m.`id_product` = a.`id_product`)';

    		$this->fields_list = array(    	
    			'id_product_attribute' => array(
    				'title' => $this->l('Set'),
    				'align' => 'center',
    				'width' => 60,
    				'remove_onclick' => true
    			),
    			'variation' => array(
    				'title' => $this->l('Variation'),
    				'align' => 'center',
    				'class' => 'massivo_variation',
    				'callback' => 'displayAttributeResume', 
    				'width' => 'auto',   	   				
    				'remove_onclick' => true
    			),
    			'image' => array(
                    'title' => $this->l('Image'),
                    'align' => 'center',              
                    'width' => 70,
                    'image' => 'p',  
                    'image_id' => 'id_image',                               
                    'filter' => false,                           
                    'search' => false,      
                    'remove_onclick' => true                 
                ),
    			'id_product' => array(
    				'title' => $this->l('Product'),
    				'align' => 'center',
    				'width' => 'auto',
    				'filter_type' => 'int',
    				'filter_key' => 'a!id_product',
    				'search' => true,
    				'filter' => true,
    				'callback' => 'displayProductLink',
    				'remove_onclick' => true,    					
    			),    			
    			'reference' => array(
    				'title' => $this->l('Reference'),
    				'type' => 'editable',    				
    				'align' => 'center',
    				'width' => 'auto',
    				'ajax' => true,
    				'remove_onclick' => true
    			),
    			'ean13' => array(
    				'title' => $this->l('EAN13'),
    				'type' => 'editable',    				
    				'align' => 'center',
    				'remove_onclick' => true
    			)/*,
    			'canonic_product' => array(
    				'title' => $this->l('Canonic'),
    				'type' => 'text',
    				'align' => 'center',
    				'callback' => 'displayCanonicProductLink',
    				'remove_onclick' => true    				
    			)  */  
    		);
    		$this->context = Context::getContext();
    		$this->addRowAction('view');    
    		parent::__construct();    		
		}
		public function renderList()
	    {
	        if (!($this->fields_list && is_array($this->fields_list))) {
	            return false;
	        }
	        $this->getList($this->context->language->id);
	        $t = count($this->_list); $i = 0;
	        while ($i < $t)
	        {
	        	$this->_list[$i]['id'] = $i;
	        	if ($this->_list[$i]['ean13'] == NULL )
	        	{
	        		$this->_list[$i]['ean13'] = '';
	        	}	        	
				$this->_list[$i]['id_image'] = $this->displayAttributeImage($this->_list[$i]['id_product_attribute'], $this->_list[$i]['id_product']);	        	
				$this->_list[$i]['variation'] = $this->_list[$i]['id_product_attribute'];		        	
	        	if (!is_int((int)$this->_list[$i]['canonic_product'])) $this->_list[$i]['canonic_product'] = $this->l('Not set');
	        	$i++;
	        }	 	             
	        // If list has 'active' field, we automatically create bulk action
	        if (isset($this->fields_list) && is_array($this->fields_list) && array_key_exists('active', $this->fields_list)
	            && !empty($this->fields_list['active'])) {
	            if (!is_array($this->bulk_actions)) {
	                $this->bulk_actions = array();
	            }

	            $this->bulk_actions = array_merge(array(
	                'enableSelection' => array(
	                    'text' => $this->l('Enable selection'),
	                    'icon' => 'icon-power-off text-success'
	                ),
	                'disableSelection' => array(
	                    'text' => $this->l('Disable selection'),
	                    'icon' => 'icon-power-off text-danger'
	                ),
	                'divider' => array(
	                    'text' => 'divider'
	                )
	            ), $this->bulk_actions);
	        }

	        $helper = new HelperList();

	        // Empty list is ok
	        if (!is_array($this->_list)) {
	            $this->displayWarning($this->l('Bad SQL query', 'Helper').'<br />'.htmlspecialchars($this->_list_error));
	            return false;
	        }

	        $this->setHelperDisplay($helper);
	        $helper->_default_pagination = $this->_default_pagination;
	        $helper->_pagination = $this->_pagination;
	        $helper->tpl_vars = $this->getTemplateListVars();
	        $helper->tpl_delete_link_vars = $this->tpl_delete_link_vars;

	        // For compatibility reasons, we have to check standard actions in class attributes
	        foreach ($this->actions_available as $action) {
	            if (!in_array($action, $this->actions) && isset($this->$action) && $this->$action) {
	                $this->actions[] = $action;
	            }
	        }

	        $helper->is_cms = $this->is_cms;
	        $helper->sql = $this->_listsql;
	        $list = $helper->generateList($this->_list, $this->fields_list);
	        return $this->ajaxLoader() . $this->displayTabsHeader() . $this->renderEditTab($list) .  $this->renderApplyTab() . $this->renderCreateTab() . '</div>';
	    }
    	public function getIdRow()
		{
			return '1';
		}

		/*
		*	function getAttributeImage
		*	Get associated image for an attribute combination, or returns image for main product if none found
		*	param: id_product_attribute
		*/
		public function displayAttributeImage($combination,$product)
		{
			//Get Product from combination			
			$lang = $this->context->language->id;
			$image = Product::getCombinationImageById($combination,$lang);

			if ($image)
				$val = $image;
			else
			{
				$prod = new Product($product);
				$image = $prod->getCover($product)['id_image'];
				$val = $image;				
			}
			return $val;
		}
		/**
		 * @param  $combination : Combination id
		 * @param  $product : Product combination, including all vars
		 * @return String
		 */
		public function displayAttributeResume($combination,$product)
		{			
			$prod = new Product($product);			
			$r = $prod->getAttributesParams($product['id_product'],$combination);			
			$this->context->smarty->assign('rows',$r);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayAttributeResume.tpl');
			return $tpl;			
		}

		/**
		 * [displayProductLink Link ]
		 * @param  [type] $combination [description]
		 * @param  [type] $product     [description]
		 * @return [type]              [description]
		 */
		public function displayProductLink($combination,$product)
		{
			$prod = new Product($product['id_product']);						
			$r = $this->context->link->getAdminLink('AdminProducts');					
			$this->context->smarty->assign(
				array(
					'productControllerLink' => $r,
					'productId' => $prod->id,
					'productName' => $prod->name[$this->context->language->id]
				)
			);			

			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayProductControllerLink.tpl');
			return $tpl;
		}

		/**
		 * [displayCanonicProductLink description]
		 * @param  [type] $combination [description]
		 * @param  [type] $product     [description]
		 * @return [type]              [description]
		 */
		public function displayCanonicProductLink($combination,$product)
		{
			$prod = new Product($product['canonic_product']);						
			$r = $this->context->link->getAdminLink('AdminProducts');					
			$this->context->smarty->assign(
				array(
					'productControllerLink' => $r,
					'productId' => $prod->id,
					'productName' => $prod->name[$this->context->language->id]
				)
			);			

			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayProductControllerLink.tpl');
			return $tpl;
		}

		/*
		*	function renderView
		*	Renders View Button on list
		*/
		public function renderView()
		{
			$tpl = $this->context->smarty->createTemplate(_PS_MODULE_DIR_ . '/massivo/views/templates/admin/renderView.tpl');
			return $tpl->fetch();
		}
		/*
		 *	function ajaxLoader
		 *	Adds Ajax script to rendered list
		 *
		 */
		private function ajaxLoader()
		{
			$massivoKey = Configuration::get('massivo_key');
			$js = _PS_MODULE_DIR_ . '/massivo/js/ajaxLoader.js';
			$this->context->smarty->assign(
				array(
				'module_dir' => _MODULE_DIR_,
				'massivo_key' => $massivoKey
				)
			);
			$html = $this->context->smarty->fetch($js);
			return $html;
		}
		/**
		 * [displayTabs Display Tabs on top of admincontroller]
		 * @return [type] [description]
		 */
		private function displayTabsHeader($tab = 3)
		{
			$this->context->smarty->assign(
				array(
					"massivo_key" => Configuration::get('massivo_key'),				
					"tab" => $tab					
				)
			);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/tabs/massivoTabsHeader.tpl');			
			return $tpl;
		}
		/**
		 * [renderEditTab description]
		 * @return [type] [description]
		 */
		private function renderEditTab($list)
		{
			$this->context->smarty->assign('editlist',$list);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/tabs/renderEditTab.tpl');
			return $tpl;
		}
		/** [renderApplyTab renders hidden Apply Tab] */
		private function renderApplyTab()
		{
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/tabs/renderApplyTab.tpl');
			return $tpl;
		}
		/**
		 * [renderCreateTab renders hidden Create Tab]
		 * @return [type] [description]
		 */
		private function renderCreateTab()
		{
			$scriptsTable = $this->renderExistingScriptsTable();
			$this->context->smarty->assign(
				array(
					'scriptsTable' => $scriptsTable
				)
			);			
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/tabs/renderCreateTab.tpl');
			return $tpl;
		}
		private function renderExistingScriptsTable()
		{
			$scripts = $this->getScripts();		
			$scripts = array(
				array(
					'id_script' => 0,
					'name' => 'test'
				)
			);	
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
			
			//createSkeletonHelperTable
			//Add functions to buttons
		}

		/**
		 * [getScripts return Scripts list on massivo_script table. A Script can have N triggers]
		 * @return [array] [list of scripts, each row]
		 */
		private function getScripts()
		{
			$sql = new DBQuery();
			$sql->select('*');
			$sql->from('massivo_script');
			$scripts = Db::getInstance()->executeS($sql);
			return $scripts;
		}
	}

?>