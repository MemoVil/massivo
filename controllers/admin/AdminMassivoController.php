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
    				'align' => 'center'
    			),
    			'id_product' => array(
    				'title' => $this->l('Product'),
    				'align' => 'center'    					
    			),
    			'reference' => array(
    				'title' => $this->l('Reference'),
    				'align' => 'center'
    			),
    			'ean13' => array(
    				'title' => $this->l('EAN13'),
    				'align' => 'center'
    			),
    			'canonic_product' => array(
    				'title' => $this->l('Canonic'),
    				'align' => 'center'
    			)
    		);
    		$this->context = Context::getContext();
    		parent::__construct();
		}
		public function getCombinationId($id)
		{

		}
		public function getProductId($id)
		{

		}
		public function getReferenceId($id)
		{

		}
		public function getEanId($id)
		{

		}
		public function getCanonicProductId($id)
		{

		}
	}

?>