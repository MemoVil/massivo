<?php
	trait scription
	{
		public $modulename = 'massivo';
		public $moduleDb = 'massivo_script';
		const ERROR_NAME_TOO_SHORT = 1;
		const ERROR_NAME_ALREADY_EXIST_OR_MISSING_DB = 2;
		const BLANK_SCRIPT_CREATED = 3;
		const ERROR_ON_UPDATE_VARS = 4;
		const TABLE_MASSIVO_UPDATED = 5;
		/**
		 * [createScript Creates a script skeleton]
		 * @param  [String] $name [name of script]
		 * @return [INT]       [ERROR CODE]
		 */
		public function createScript($name)
		{
			if ( strlen($name) < 1)
				return ERROR_NAME_TOO_SHORT;
			$sql = new DBQuery();
			$sql->select('name')->from($moduleDb)->where('name =' . $name);
			$r = Db::getInstance()->executeS($sql);
			if (count($r) > 0)
				return ERROR_NAME_ALREADY_EXIST_OR_MISSING_DB;
			
			Db::getInstance()->insert($moduleDb, array(
				'name' => pSQL($name)
			));
			return $this;
		}
		/**
		 * [update updates a record on DB]
		 * @param  [INT] $id   [Script ID]
		 * @param  [type] $blob [description]
		 * @return [type]       [description]
		 */
		public function updateScript($id,$arrayToBlob)
		{
			$id = (INT) $id;
			$blob = serialize($arrayToBlob);
			Db::getInstance()->update($moduleDb,array(
				'script' => $blob
				),
				'id_script = ' .$id,
				1
			);
			if ($error = Db::getInstance()->getNumberError() > 0)
				return $error;
			return $this;
		}
		/**
		 * [getScript get Script ARray]
		 * @param  [type] $name [description]
		 * @return [array] Array full of triggers
		 */
		public function getScript($id)
		{
			$sql = new DBQuery();
			$sql->select('*')->from($massivoDb)->where('id_script =' . (int)$id);
			$r = Db::getInstance()->getRow($sql);
			if ($error = Db::getInstance()->getNumberError() > 0)
				return $error;
			return unserialize($r['script']);
		}
		/**
		 * [deleteScript deletes a full script array]
		 * @param  [type] $id [description]
		 * @return [type]     [description]
		 */
		public function deleteScript($id)
		{
			$id = (int) $id;
			DB::getInstance()->delete($massivoDb,'id_script =' .$id,1);
			return $this;
		}
		/**
		 * [addTrigger Adds a full trigger to a script. If trigger id is used it overwrites it without prompting]
		 * @param [int] $id_script      [description]
		 * @param [int] $id_trigger     [description]
		 * @param [array] $trigger_params [description]
		 *  Script
		 *  |_______Trigger
		 *  			|______Params
		 *  					 |_______{If Condition from below condition list}
		 *          					 	{Attribute from attribute group}
		 *          					  	{Attribute from attribute list}
		 *          					  	{Has tags}
		 *          					   		{Matching...}
		 *          					   			{Then....}
		 *          					   				{Adds text to string and evals next trigger to append text}
		 */
		public function addTrigger($id_script,$id_trigger,$trigger_params)
		{
			$script = $this->getScript((int)$id_script);
			$script[(int)$id_trigger] = $trigger_params;
			return $this;
		}
	}
?>