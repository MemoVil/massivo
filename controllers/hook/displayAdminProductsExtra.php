<?php
	class massivoDisplayAdminProductsExtraController
	{
		public function __construct($module,$file,$path)
		{
			$this->file = $file;
			$this->module = $module;
			$this->context = Context::getContext();
			$this->_path = $path;
		}
		public function run($product,$params)
		{
			ddd($product);
		}
	}
?>