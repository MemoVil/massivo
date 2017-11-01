<?php
	/*
		1. Install Methods.
		2. Uninstall Methods.	
	
	*/
trait installMaster {	
	public $moduleName = 'massivo';


	public function install()
	{	
		if (!parent::install()
			|| !$this->setHooks()
			|| !$this->setVars())
			return false;

		return true;			

	}

	public function setHooks()
	{
		return true;
	}
	public function setVars()
	{
		return true;
	}

	/** 2. Uninstall methods */
	public function uninstall()
	{
		if (!parent::uninstall()
			|| !$this->unsetHooks()
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

}
?>