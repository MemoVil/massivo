<?php
/*
	Massivo: Acciones masivas para catálogo mediante controladores de backoffice
	Opciones disponibles:

*/

if (!defined('_PS_VERSION_'))
  exit;

// Adding explicit external files from include folder
$includes = array(
				__DIR__ . '/includes/install.php',
				__DIR__ . '/classes/ProductAttribute.php'
			);
foreach ($includes as $addsource)
{
	include_once($addsource);	
}


Class massivo extends Module 
{
	use installMaster;
	public function __construct()
	{
		
		$this->name = 'massivo';
	    $this->tab = 'front_office_features';
        $this->version = '0.3';
        $this->author = 'Juan Parente';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6.1', 'max' => '1.7'); 
        $this->bootstrap = true;
        $this->protocol = 'https://';
        parent::__construct();
        $this->displayName = $this->l('Massivo');
        $this->description = $this->l('Canonic linking of your products, allowing you at the same time to make referencing them faster and easier');
        $this->confirmUninstall = $this->l('Do you really want to uninstall this module?');   
	}
	public function getContent()
	{

	}
	
	public function hookDisplayAdminProductsExtra($params)
	{
	    if (Validate::isLoadedObject($product = new Product((int)Tools::getValue('id_product'))))
	    {
	    	$controller = $this->getHookControlleR('displayAdminProductsExtra');
	    	return $controller->run();
	    }
	}		
	
	/**
	 * [getHookController description]
	 * @param  [String] $hook_name [Name of the hook without Controller tag]
	 * @return [Object]            [Instanced Controller]
	 */
	public function getHookController($hook_name)
	{
		// Include the controller file
		require_once(dirname(__FILE__).'/controllers/hook/'.
		$hook_name.'.php');
		// Build the controller name dynamically
		$controller_name = $this->name.$hook_name.'Controller';
		// Instantiate controller
		$controller = new $controller_name();
		// Return the controller
		return $controller;
	}
}

?>