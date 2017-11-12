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
		 	!$this->createTable() OR        
			!$this->registerHook('displayAdminProductsExtra') OR
			!$this->registerHook('actionAdminControllerSetMedia') OR
        	!$this->registerHook('actionProductUpdate') 
			)
			return false;
		return true;
	}
	public function setVars()
	{
		if (!Configuration::updateValue('massivo_key',md5(microtime())) )
			return false;
		return true;
	}
	/**
	 * [setController hooks controller on catalog tab]
	 */
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
			|| !$this->removeTable()  
			|| !$this->unsetHooks()
			|| !$this->unsetController()
			|| !$this->unsetVars())			
			return false;
		return true;
	}
	public function unsetVars()
	{
		if (!Configuration::deleteByName('massivo_key') )
			return true;
		return true;
	}
	public function unsetHooks()
	{
	
		return true;
	}
	public function unsetController()
	{
		if (!$this->uninstallTab('AdminMassivo'))
			return false;
		return true;
	}
	/**
	 * [uninstallTab Removes controller main tab on Catalog]
	 * @param  [String] $class_name [Controller class name]
	 * @return [boolean]             [fail state]
	 */
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
	/**
	 * [createTable Creates massivo table]
	 * @return [boolean] [fail state]
	 */
	public function createTable()
    {
        $return = true;
        $return &= Db::getInstance()->execute('
            CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'massivo` (
                `id_product` INT UNSIGNED NOT NULL AUTO_INCREMENT,                               
                `canonic_product` INT,
                `active` INT,
                PRIMARY KEY (id_product)
            ) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8 ;');
        return $return;
    }
    /**
     * [removeTable Removes massivo table]
     * @return [boolean] [fail state]
     */
    public function removeTable()
    {        
        return Db::getInstance()->execute('DROP TABLE IF EXISTS `'._DB_PREFIX_.'massivo`');
    }
   

}
?>