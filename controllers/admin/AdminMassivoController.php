<?php  
	

	class AdminMassivoController extends ModuleAdminController
	{
		public function __construct()
		{
			$this->table = 'product_attribute';
    		$this->className = 'ProductAttribute';
    		$this->page_header_toolbar_title = $this->l('Massivo');
    		$this->bootstrap = true;
    		$this->colorOnBackground = true;
    		$this->row_hover = true;
    		$this->addCSS(_PS_MODULE_DIR_ .'/massivo/css/AdminMassivoController.css');
    		$this->fields_list = array(    	
    			'id_product_attribute' => array(
    				'title' => $this->l('Combination'),
    				'align' => 'center',
    				'remove_onclick' => true
    			),
    			'variation' => array(
    				'title' => $this->l('Variación'),
    				'align' => 'center',
    				'class' => 'massivo_variation',
    				'callback' => 'getAttributeResume',    	   				
    				'remove_onclick' => true
    			),
    			'image' => array(
                    'title' => $this->l('Imagen'),
                    'align' => 'center',              
                    'width' => 70,
                    'image' => 'p',  
                    'image_id' => 'id_image',                               
                    'filter' => 'false',                    
                    'search' => 'false',      
                    'remove_onclick' => true                 
                ),
    			'id_product' => array(
    				'title' => $this->l('Product'),
    				'align' => 'center',
    				'width' => 50,
    				'remove_onclick' => true,    					
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
				$this->_list[$i]['id_image'] = $this->getAttributeImage($this->_list[$i]['id_product_attribute'], $this->_list[$i]['id_product']);	        	
				$this->_list[$i]['variation'] = $this->_list[$i]['id_product_attribute'];			
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

	        return $this->ajaxLoader() . $list;
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
		public function getAttributeImage($combination,$product)
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
		public function getAttributeResume($combination,$product)
		{			
			$prod = new Product($product);			
			$r = $prod->getAttributesParams($product['id_product'],$combination);			
			$this->context->smarty->assign('rows',$r);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . '/massivo/views/templates/admin/getAttributeResume.tpl');
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
			$html='<script type="text/javascript">
			$(document).ready(function() {
				$("input.reference:text").change(
					function()
					{
						$comb = $(this).parent().parent().children(":first-child").html().trim();
						$val = $(this).val();
						/**console.log($comb); */
						if ($comb.length > 0 && $val.length > 0)
						{
					       $.ajax({
				              url: "'._MODULE_DIR_.'massivo/classes/ajax/ajax-controller.php",
				              method: "POST",
				              data: { combination : $comb, val : $val, type :"reference", massivo_key : "' . $massivoKey . '"} ,
				              dataType: "json",
				              context: document.body,
				              error: function(xhr,status,error) {               
				              },
				              success: function (response) {               
				                var retorno = response;
				                if ( retorno == 0 )
				                {
				                    
				                }                
				          
				              }
				            });
						}
					}
				);
					$("input.ean13:text").change(
					function()
					{
						$comb = $(this).parent().parent().children(":first-child").html().trim();
						$val = $(this).val();
						/**console.log($val);*/					
						if ($comb.length > 0 && $val.length > 0)
						{
					       $.ajax({
				              url: "'._MODULE_DIR_.'massivo/classes/ajax/ajax-controller.php",
				              method: "POST",
				              data: { combination : $comb.trim(), val : $val, type : "ean13", massivo_key : "' . $massivoKey . '"} ,
				              dataType: "json",
				              context: document.body,
				              error: function(xhr,status,error) {               
				              },
				              success: function (response) {               
				                var retorno = response;
				                if ( retorno == 0 )
				                {
				                    
				                }                
				          
				              }
				            });
						}
					}
				);
			});
	                         
	        </script>';
	        return $html;
		}
	}

?>