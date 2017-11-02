<?php  
	

	class MassivoProductAttributesController extends AdminAttributeGeneratorController
	{
		public function __construct()
		{
			$this->table = 'product_attributes';
    		$this->className = 'ProductAttributes';
    		$this->page_header_toolbar_title = $this->l('Massivo');
    		$this->bootstrap = true;
    		$this->fields_list = array(
    			'id_product_attribute' => array(
    				'title' => $this->l('Combination'),
    				'align' => 'center',
    				'callback' => 'getCombinationId'
    			),
    			'id_product' => array(
    				'title' => $this->l('Product'),
    				'align' => 'center',
    				'callback' => 'getProductId'	
    			),
    			'reference' => array(
    				'title' => $this->l('SKU'),
    				'align' => 'center',
    				'callback' => 'getSkuId'
    			),
    			'ean13' => array(
    				'title' => $this->l('EAN13'),
    				'align' => 'center',
    				'callback' => 'getEanId'
    			),
    			'canonic_product' => array(
    				'title' => $this->l('Canonic'),
    				'align' => 'center',
    				'callback' => 'getCanonicProductId'
    			)
    		);
    		$this->context = Context::getContext();
    		parent:__construct();
		}
		public function getCombinationId($id)
		{

		}
		public function getProductId($id)
		{

		}
		public function getSkuId($id)
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