<?php
/*
	Massivo: Acciones masivas para catálogo mediante controladores de backoffice
	Opciones disponibles:

*/

if (!defined('_PS_VERSION_'))
  exit;

// Adding explicit external files from include folder
$includes = array(
				__DIR__ . '/includes/install.php'
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
		parent::__construct();
		$this->name = 'massivo';
	    $this->tab = 'front_office_features';
        $this->version = '0.1';
        $this->author = 'Juan Parente';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6.1', 'max' => '1.7'); 
        $this->bootstrap = true;
        $this->protocol = 'https://';
        
        $this->displayName = $this->l('Massivo');
        $this->description = $this->l('Make your life easier with massive actions on your store');
        $this->confirmUninstall = $this->l('Do you really want to uninstall this module?');   
	}
	public function getContent()
	{

	}
}

?>