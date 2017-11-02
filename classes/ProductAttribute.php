<?php 
	class ProductAttribute extends ObjectModel
	{
		public $id_product_attribute;
		public $id_product;
		public $reference;
		public $ean13;
		public $canonic_product;
		public static $definition = array(
			'table' => 'product_attribute',
			'primary' => 'id_product_attribute',
			'multilang' => false,
			'fields' => array(
				'id_product_attribute' => array(
					'type' => SELF::TYPE_INT,
					'validate' => 'isUnsignedId',
					'required' => true
				),
				'id_product' => array(
					'type' => SELF::TYPE_INT,
					'validate' => 'isUnsignedId',
					'required' => true
				),
				'reference' => array(
					'type' => self::TYPE_STRING,
					'required' => false
				),
				'ean13' => array(
					'type' => self::TYPE_STRING,
					'required' => false
				),
				'canonic_product' => array(
					'type' => SELF::TYPE_INT,
					'validate' => 'isUnsignedId',
					'required' => false
				)
			)
		);
	}
?>