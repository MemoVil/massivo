<?php
	/* Trait for several classes, to make them a bit smaller */
	trait scription
	{
		public static $modulename = 'massivo';
		public static $moduleDb = 'massivo_recipes';
		/**
		 * [getTime get secs to generate unique ids]
		 * @return [type] [description]
		 */
		public function getTime()		
		{
		 list($usec, $sec) = explode(" ", microtime());
		 return $sec + (int)(round($usec * 1000));
		}
		/**
		 * [isLegal Checks if a string is secure]
		 * @param  [type]  $pattern [description]
		 * @return boolean          [description]
		 */
		public function isLegal($pattern)
	    {
	        if (Configuration::get('PS_ALLOW_ACCENTED_CHARS_URL')) {
	            return preg_match(Tools::cleanNonUnicodeSupport('/^[_a-zA-Z0-9 \,\;\"\(\)\.{}:\/\pL\pS-]+$/u'), $pattern);
	        }
	        return preg_match('/^[_a-zA-Z0-9 áéíóúÁÉÍÓÚäëïöüçñÑàèìòù#\,\;\(\)\.{}:\/\-]+$/', $pattern);
	    }
	    /**
		 * [generateRandomString Generates a random string]
		 * @param  integer $length [description]
		 * @return [type]          [description]
		 */
		public function generateRandomString($length = 10) {
	    	return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
		}
		/**
		 * [getScripts return Scripts list on massivo_recipes table. A Script can have N triggers]
		 * @return [array] [list of scripts, each row]
		 */
		public static function getScripts()
		{
			$sql = new DBQuery();
			$sql->select('*');
			$sql->from(self::$moduleDb);
			$scripts = Db::getInstance()->executeS($sql);
			return $scripts;
		}
		/** Showing msgs via Ajax */
		public function success($message)
		{
			echo 'Success$' . $message;
		}
		public function error($message)
		{
			echo 'Error$' . $message;
		}
	}
?>