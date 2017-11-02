<?php  
	

	class AdminMassivoController extends ModuleAdminController
	{
		public function __construct()
		{
			$this->table = 'product_attribute';
    		$this->className = 'ProductAttribute';
    		$this->page_header_toolbar_title = $this->l('Massivo');
    		$this->bootstrap = true;
    		$this->fields_list = array(    	
    			'id_product_attribute' => array(
    				'title' => $this->l('Combination'),
    				'align' => 'center',
    				'remove_onclick' => true
    			),
    			'id_product' => array(
    				'title' => $this->l('Product'),
    				'align' => 'center',
    				'remove_onclick' => true    					
    			),    			
    			'reference' => array(
    				'title' => $this->l('Reference'),
    				'type' => 'editable',    				
    				'align' => 'center',
    				'ajax' => true,
    				'remove_onclick' => true
    			),
    			'ean13' => array(
    				'title' => $this->l('EAN13'),
    				'type' => 'editable',    				
    				'align' => 'center',
    				'remove_onclick' => true
    			),
    			'canonic_product' => array(
    				'title' => $this->l('Canonic'),
    				'type' => 'editable',
    				'align' => 'center',
    				'remove_onclick' => true
    			)    
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

	        return $list;
	    }
    	public function getIdRow()
		{
			return '1';
		}
		public function renderView()
		{
			$tpl = $this->context->smarty->createTemplate(_PS_MODULE_DIR_ . '/massivo/views/templates/admin/fastedit.tpl');
			return $tpl->fetch();
		}
	}

?>