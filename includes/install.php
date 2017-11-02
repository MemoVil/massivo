<?php
	/*
		1. Install Methods.
		2. Uninstall Methods.	
		3. Other Methods.
	
	*/
trait installMaster {	
	public $moduleName = 'massivo';


	public function install()
	{	
		if (!parent::install()
			|| !$this->setHooks()
			|| !$this->setController()
			|| !$this->setVars())
			return false;		 
		return true;	
	}
	public function setHooks()
	{
		if (
		 	!$this->alterTable('add') OR        
			!$this->registerHook('displayAdminProductsExtra') OR
			!$this->registerHook('actionAdminControllerSetMedia') OR
        	!$this->registerHook('actionProductUpdate') 
			)
			return false;
		return true;
	}
	public function setVars()
	{
		return true;
	}
	public function setController()
	{
		if (
			!$this->installTab('AdminCatalog', 'AdminMassivo','Massivo')
			)	
			return false;
		return true;
	}
	public function installTab($parent, $class_name, $name)
	{
		// Create new admin tab
		$tab = new Tab();
		$tab->id_parent = (int)Tab::getIdFromClassName($parent);
		$tab->name = array();
		foreach (Language::getLanguages(true) as $lang)
		$tab->name[$lang['id_lang']] = $name;
		$tab->class_name = $class_name;
		$tab->module = $this->name;
		$tab->active = 1;
		return $tab->add();
	}



	/** 2. Uninstall methods */
	public function uninstall()
	{
		if (!parent::uninstall()			
			|| !$this->alterTable('remove')  
			|| !$this->unsetHooks()
			|| !$this->unsetController()
			|| !$this->unsetVars())			
			return false;
		return true;
	}
	public function unsetVars()
	{
		return true;
	}
	public function unsetHooks()
	{
	
		return true;
	}
	public function unsetController()
	{
		if (!$this->uninstallTab('MassivoProductAttributesController'))
			return false;
		return true;
	}
	public function uninstallTab($class_name)
	{
		// Retrieve Tab ID
		$id_tab = (int)Tab::getIdFromClassName($class_name);
		// Load tab
		$tab = new Tab((int)$id_tab);
		// Delete it
		return $tab->delete();
	}

	//3 Other Metods
	public function alterTable($method)
	{
	    switch ($method) {
	        case 'add':
	            $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product_attribute ADD `canonic_product` INT(8) ';
	            break;
	         
	        case 'remove':
	            $sql = 'ALTER TABLE ' . _DB_PREFIX_ . 'product_attribute DROP COLUMN `canonic_product`';
	            break;
	    }
	     
	    if(!Db::getInstance()->Execute($sql))
	        return false;
	    return true;
	}

}
?>