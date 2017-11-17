<?php
	if (!defined('_PS_VERSION_'))
  		exit;

	class massivoDisplayAdminProductsExtraController 
	{
		public function __construct($module,$file,$path)
		{
			$this->file = $file;
			$this->module = $module;
			$this->context = Context::getContext();
			$this->_path = $path;
			$this->product = null;			
			
		}
		public function run($product,$params)
		{			
			if ($product)
			{
				$this->product = $product;
				$this->selectMode(1);
			}
			else 
			{
				$this->error('Wrong parameters');
			}
		}
		/**
		 * [selectMode selects option to trigger on start menu]
		 * @return [type] [description]
		 */
		public function selectMode($tab)
		{
			$this->context->smarty->assign(
				array(
					"massivo_key" => Configuration::get('massivo_key'),
					"product" => $this->product					
				)
			);
			$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayAdminProductsExtraSelectMode.tpl');
			echo $tpl;
		}

	}
?>