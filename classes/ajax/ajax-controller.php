<?php 
include_once('../../../../config/config.inc.php');
include_once('../../../../init.php');


class SQL {
	const	COMBINATIONS = _DB_PREFIX_ . 'product_attribute';
	const	COMBINATIONSLIST = _DB_PREFIX_ . 'product_attribute_combination';
	const	PRODUCTDESCRIPTIONS = _DB_PREFIX_ . 'product_lang';
	const	PRODUCTTAGS  = _DB_PREFIX_ . 'product_tag';
	const	PRODUCTS = _DB_PREFIX_ . 'product';
	const	ATTRIBUTES = _DB_PREFIX_ . 'attribute';
	const	ATTRIBUTEGROUP = _DB_PREFIX_ . 'attribute_group';
	const	ATTRIBUTELANG = _DB_PREFIX_ . 'attribute_lang';
	const	ATTRIBUTEGROUPLANG = _DB_PREFIX_ . 'attribute_group_lang';
}
class AjaxWorker {	
	public $safe = false;
	public $intEcho = 1;
	public $header ='Content-Type: application/json';
	public $post = array();
	
	//Validate $post to avoid XSS and dumb entries
	public function validatePost($post)
	{
		$massivoKey = Configuration::get('massivo_key');
		if (array_key_exists('massivo_key', $post))
		{			
			if ( strcmp($post['massivo_key'], $massivoKey) === 0 )
			{
				$this->safe = true;
				$this->intEcho += 10;				
			}
		}
		foreach($post as $key => $value)
		{
			if (Validate::isModuleName($value))
			{
				$this->intEcho += 10; 
			}
			else
			{
				$this->safe = false;
				$this->intEcho = -1;
			}
		}
		return $this->safe;
	}
	public function load($post)
	{
		foreach ($post as $key=>$value)
		{
			$key = strtolower($key);
			if (Validate::isModuleName($key) && Validate::isRoutePattern($value))
			$this->post[$key] = $value;
		}
	}
	public function displayError()
	{
		header($this->header);
		echo "Invalid access";	
	}
	// Display internal debug data
	public function debug() 
	{
		header($this->header);
		ppp($this->post);
	}

}
$ajax = new AjaxWorker();
if ( !$ajax->validatePost($_POST) ) 
{
	$ajax->displayError();	
}
else {
	$ajax->load($_POST);
	$ajax->debug();	
}


?>