<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	include_once(__DIR__ .'/Trigger.php');

	class Recipe
	{
		public $name;
		public $id;		
		public $triggers;

		/**
		 * [addTrigger Adds a new trigger object to this recipe, adding params on it]
		 * 				Triggers DO NOT need a name;
		 * @param [Trigger] $newTrigger [new Trigger to be added]
		 */
		public function addTrigger($newTrigger)
		{
			/* We can only add Trigger objects */
			if (get_class($newTrigger) != 'Trigger')
				return false;
			/* Is this trigger already added? */
			foreach ($triggers as $indice => $trigger)
			{
				if 	($trigger->id == $newTrigger->id)
					return false;
			}
			$newTrigger->position = count($this->triggers);
			$newTrigger->recipe = $this->id;			
			$this->triggers[] = $newTrigger;
			return $this;
		}
		/**
		 * [removeTrigger removes a Trigger object from array list of this recipe]
		 * @param  [Trigger] $removeTrigger [trigger to be removed]
		 *         [Boolean] $save
		 * @return [boolean]                [true if deleted, false if not found]
		 */
		public function removeTrigger($removeTrigger,$save = true)
		{
			if (get_class($removeTrigger) != 'Trigger')
				return false;
			foreach ($this->triggers as $indice => $trigger)
			{
				if 	($trigger->unicId == $newTrigger->unicId)
				{
					unset($this->triggers[$indice]);				
					$key = $indice;
				}					
				if (isset($key) && $indice > $key)
				{
					$trigger->position--; 
					$this->triggers[$indice - 1] = $trigger;
				}				
			}
			/* If we found the key we must delete old duplicated key */
			if (isset($key))
			{
				if ( $key <= count($this->triggers) )
					unset($this->triggers[count($this->triggers)]);
				if ($save) $this->save();
				return true;
			}
			/* We didn't found the key */
			else return false;
			
		}
		/**
		 * [getTrigger gets a Trigger bassed on it's trigger order, as id is not intended for this purpose]
		 * @param  [int] $position [integer with position order,starting by 0]
		 * @return [Trigger or boolean]            []
		 */
		public function getTrigger($position)
		{
			$position = (int)$position;
			if ($position < count($this->triggers))
				return $this->triggers[$position];
			else return false;
		}

		public function getAllTriggers()
		{
			return $this->triggers;
		}

		/**
		 * [downTrigger We down one step a trigger position]
		 * @param  [Trigger] $trigger [description]
		 * @param  [type] $save    [description]
		 * @return [type]          [description]
		 */
		public function downTrigger($trigger, $save)
		{
			if (get_class($trigger) != 'Trigger')
				return false;	
			if ($trigger->recipe != $this->id)
				return false;
			switch ($trigger->position)
			{
				//It's the last one, we can't down it
				case (count($this->triggers) - 1):
					return false;
					break;
				default:
					//We save trigger to be overwritten
					$temp = $this->triggers[$trigger->position + 1];					
					$temp->position--;
					$trigger->position++;
					//We overwrite it...					
					$this->triggers[$trigger->position + 1] = $trigger;
					//And we put saved trigger on position of upped trigger;
					
					$this->triggers[$trigger->position - 1] = $temp;
					return true;
					break;										
			}
			if ($save) $this->save();
		}

		/**
		 * [upTrigger Ups a Trigger by one position]
		 * @param  [Trigger] $trigger [description]
		 * @param  [Boolean] $save    [description]
		 * @return [Boolean]          [description]
		 */
		public function upTrigger($trigger, $save)
		{
			if (get_class($trigger) != 'Trigger')
				return false;	
			if ($trigger->recipe != $this->id)
				return false;
			switch ($trigger->position)
			{
				//It's the first one, we can't up it
				case 0:
					return false;
					break;
				default:
					//We save trigger to be overwritten
					$temp = $this->triggers[$trigger->position - 1];
					$temp->position++;					
					$trigger->position--;
					//We overwrite it...					
					$this->triggers[$trigger->position - 1] = $trigger;
					//And we put saved trigger on position of upped trigger;
					$this->triggers[$trigger->position + 1] = $temp;
					return true;
					break;										
			}
			if ($save) $this->save();
		}

		/**
		 * [save Saves Recipe on DB]
		 * @return [type] [description]
		 */
		public function save()
		{
			$sql = new Db::getInstance();
			$sql->update(
				'massivo_recipes',
				array(
					'id' => $this->id,
					'name' => pSQL($this->name),
					'recipe' => serialize($this)
				)
			);			
		}

		/** Returns an unserialized object to be instantiated from scription trait */
		public static function load($id)
		{
			$sql = new DBQuery();
			$sql->select(*)->from('massivo_recipes')->where('id=' . (int)$id);
			$r = Db::getInstance()->executeS($sql);
			return unserialize($r['recipe']);
		}
	}
 ?>