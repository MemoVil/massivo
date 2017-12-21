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
	    	if (strlen($pattern) == 0 )
	    		return true;
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
		public function areSet()
		{
			  $args = func_get_args();
			  foreach ($args as $arg)
			  {
			  	if ($arg == null)
			  		return false;
			  }
			  return true;
		}
		public function arePost()
		{					
			if (isset($this->post))
			{			
				$args = func_get_args();				
				foreach($args as $arg)
				{					
				 	if ( !array_key_exists($arg,$this->post) )
				 		return false;				 	
				}
				return true;
			}
			return false;
		}	
		/**
		 * [raid Removes $element from $matrix and resorts all other elements on $matrix]
		 * @param  [type] $post   [description]
		 * @param  [type] $matrix [description]
		 * @return [type]         [description]
		 */
		public function raid($element,$matrix)
		{
			foreach ($matrix as $index => $value)
			{				
				if 	($value == $element)
				{						
					$key = $index;
				}					
			}
			if (isset($key))
			{
				if ($key == (count($matrix) - 1) )
				{
					unset($matrix[$key]);
				}
				else {
					foreach ($matrix as $index => $value)	
					{	
						if ($index >= $key)
						{
							$matrix[$index] = $matrix[$index+1];		
						}
					}
					unset($matrix[count($matrix) - 1]);
				}								
				return $matrix;
			}
			else return false;
		}
		/**
		 * [postLength hack overload to allow postLength to be used as: * ]
		 * $this->postLength('2') ==> Check all $_POST 
		 * $this->postLength('param','row','2') => Check param and row on $_POST
		 * @return [type] [description]
		 */
		public function postLength()
		{
			$args = func_get_args();			
			if (count($args) == 1) $length = (int)$args[0];
			else {
				$length = array_pop($args);				
				foreach ($args as $arg)
				{
					if ($arg == 'controller')
						continue;
					if (strlen($this->post[$arg]) < $length)
						return false;
				}
				return true;
			}
			if (isset($this->post))
			{	
				foreach($this->post as $key => $arg)
				{	
					if ($key == 'controller')
					{						
						continue;
					}
			 		if ( strlen($arg) < $length)			 	
			 			return false;
				}
				return true;
			}
			return false;
		}	
	}
?>