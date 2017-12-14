<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	include_once(__DIR__ .'/Step.php');

	class Recipe
	{
		public $name;
		public $id;		
		/* To be used and shared on Steps */
		public $products;
		public $product_combinations;
		public $lang;
		public $steps = array();
		public $carts;
		public $categories;		
		public $tags;
		public $client;
		public $clients;

		public function __construct()
		{
			$this->lang = Context::getContext()->language->id;	
		}
		/**
		 * [addStep Adds a new step object to this recipe, adding params on it]
		 * 				Steps DO NOT need a name;
		 * @param [Step] $newStep [new Step to be added]
		 */
		public function addStep($newStep)
		{
			/* We can only add Step objects */
			if (get_class($newStep) != 'Step')
				return false;
			/* Is this step already added? */
			foreach ($this->steps as $indice => $step)
			{
				if 	($step->id == $newStep->id)
					return false;
			}
			$newStep->position = count($this->steps);
			$newStep->recipe = $this->id;			
			$this->steps[] = $newStep;
			return $this;
		}
		/**
		 * [deleteSteps Deletes steps on string, based on its position on array]
		 * @param  [type] $steps [description]
		 * @return [Array] $ok       [Array signing ok or ko]
		 */
		public function deleteSteps($steps)
		{
			$steps = explode(" ",$steps);
			
			foreach ($steps as $step)
			{
				// We must down $step by 1 as arrays are indexed from 0
			 	$step = $step - 1;					 	
			 	if ( isset($this->steps[$step]) ){			 		
			 		$realStep[] = $this->steps[$step];		
			 	} 
			}						
			$ok = 0;
			
			//Once we know objects to be deleted, we clear them
			foreach ($realStep as $real)
			{	
				if ($this->removeStep($real))
			 	{
			 		$ok++;
			 	}			 	
			}			
			return $ok;
		}
		/**
		 * [removeStep removes a Step object from array list of this recipe]
		 * @param  [Step] $removeStep [step to be removed]
		 *         [Boolean] $save
		 * @return [boolean]                [true if deleted, false if not found]
		 */
		public function removeStep($removeStep,$save = true)
		{			
			
			if (get_class($removeStep) != 'Step')
				return false;
			
			foreach ($this->steps as $indice => $step)
			{				
				if 	($step->id == $removeStep->id)
				{						
					$key = $indice;
				}					
			}
			if (isset($key))
			{
				if ($key == (count($this->steps) - 1) )
				{
					unset($this->steps[$key]);
				}
				else {
					foreach ($this->steps as $indice => $step)	
					{	
						if ($indice >= $key)
						{
							$this->steps[$indice] = $this->steps[$indice + 1];		
						}
					}
					unset($this->steps[count($this->steps) - 1]);
				}				
				if ($save) $this->save();
				return true;
			}
			else return false;
		}
		/**
		 * [getStep gets a Step bassed on its step order, as id is not intended for this purpose]
		 * @param  [int] $position [integer with position order,starting by 0]
		 * @return [Step or boolean]            []
		 */
		public function getStep($position)
		{
			$position = (int)$position;
			if ($position < count($this->steps))
				return $this->steps[$position];
			else return false;
		}
		/**
		 * [getStepPosition Finds step on step list and return its array position ]
		 * @param  [Step] $step [description]
		 * @return [Int]        [description]
		 */
		public function getStepPosition($step)
		{
				return (array_search($step,$this->steps));
		}
		/**
		 * [getStepById  Returns a step based on its id]
		 * @param  [type] $id [description]
		 * @return [Step or Boolean]     
		 */
		public function getStepById($id)
		{
			foreach ($this->steps as $i => $step)
			{
				if ($step->id == $id)
					return $step;
			}
			return false;
		}
		/**
		 * [getStepPositionById Return position of step on recipe list]
		 * @param  [type] $id [description]
		 * @return [int or bool]
		 */
		public function getStepPositionById($id)
		{
			foreach ($this->steps as $step)
			{
				if ($step->id == $id)
					return array_search($step,$this->steps);
			}
			return false;
		}
		public function getAllSteps()
		{
			return $this->steps;
		}

		/**
		 * [downStep We down one step a step position]
		 * @param  [Step] $step [description]
		 * @param  [type] $save    [description]
		 * @return [type]          [description]
		 */
		public function downStep($step, $save)
		{
			if (get_class($step) != 'Step')
				return false;	
			if ($step->recipe != $this->id)
				return false;
			$position = array_search($step,$this->steps);
			switch ($position)
			{
				//It's the last one, we can't down it
				case (count($this->steps) - 1):
					return false;
					break;
				default:
					//We save step to be overwritten
					$temp = $this->steps[$position+1];										
					//We overwrite it...					
					$this->steps[$position + 1] = $step;
					//And we put saved step on position of upped step;					
					$this->steps[$position] = $temp;
					return true;
					break;										
			}
			if ($save) $this->save();
		}

		/**
		 * [upStep Ups a Step by one position]
		 * @param  [Step] $step [description]
		 * @param  [Boolean] $save    [description]
		 * @return [Boolean]          [description]
		 */
		public function upStep($step, $save)
		{
			if (get_class($step) != 'Step')
				return false;	
			if ($step->recipe != $this->id)
				return false;
			$position = array_search($step,$this->steps);
			switch ($position)
			{
				//It's the first one, we can't up it
				case 0:
					return false;
					break;
				default:
					//We save step to be overwritten
					$temp = $this->steps[$position - 1];
					//We overwrite it...					
					$this->steps[$position - 1] = $step;
					//And we put saved step on position of upped step;
					$this->steps[$position] = $temp;
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
			$sql = Db::getInstance()->insert(
				'massivo_recipes',
				array(
					'id' => $this->id,
					'name' => pSQL($this->name),
					'recipe' => serialize($this)
				),
				false,
				true,
				Db::REPLACE
			);			
			return $this;
		}
		/** 
		 * Returns an unserialized object to be instantiated from scription trait,
		 * 
		 *	not a new, reusing objects 
		*/
		public static function load($id)
		{
			$sql = new DBQuery();
			$sql->select('*')->from('massivo_recipes')->where('id=' . (int)$id);			
			$r = Db::getInstance()->executeS($sql);						
			$ob = unserialize($r[0]['recipe']);				
			return $ob;
		}
		/**
		 * [exist Static Boolean to verify if name of a Recipe is already used]
		 * @param  [string] $name [Name of recipe]
		 * @return [boolean]       [true/false]
		 */
		public static function exist($name)
		{
			$sql = new DBQuery();
			$sql->select('*')->from('massivo_recipes')->where('name="' . $name . '"');
			$r = Db::getInstance()->executeS($sql);					
			foreach($r as $row)
			{
				if ( strcmp($name,$row['name']) == 0 )
				{				
					return $row['id'];
				}
			}
			return 0;
		}
		/**
		 * [existById Static Boolean to verify if id of a Recipe is already used]
		 * @param  [string] $id [id of recipe]
		 * @return [boolean]       [true/false]
		 */
		public static function existById($id)
		{
			$sql = new DBQuery();
			$sql->select('*')->from('massivo_recipes')->where('id="' . $id . '"');
			$r = Db::getInstance()->executeS($sql);					
			foreach($r as $row)
			{
				if ( strcmp($id,$row['id']) == 0 )
				{				
					return $row['id'];
				}
			}
			return 0;
		}

		public static function deleteById($id)
		{			
			$sql = new DBQuery();
			$sql->select('*')->from('massivo_recipes')->where('id="' . $id . '"');
			$r = Db::getInstance()->executeS($sql);								
			foreach($r as $row)
			{
				if ( strcmp($id,$row['id']) == 0 )
				{
					$t = Db::getInstance()->delete('massivo_recipes','id="' . $id . '"');								
					return $t;
				}
			}
			return false;
		}
		/**
		 * [setProductToStep sets target of Step to one product id, useful for iterations]
		 * @param [array] $product [description]
		 */
		public function setProducts($products)
		{
			//Validate
			if (!is_array($products))
				return false;			
			foreach ($products as $product)
			{
				if ( !is_int($product) )
					return false;
			}
			$this->products = $products;
			return $this;
		}

		/**
		 * [setProductCombinations Load product combinations for selected products]
		 * @param [array] $products [array of product ids (int), to be condensed on where clause]
		 */
		public function setProductCombinations($products)
		{
			$sql = new DBQuery();
			$sql->select('*');
			$sql->from('product_attribute','p');
			foreach ($products as $product)
			{
				$sql->where('id_product =' . $product);	
			}
			$sql->innerJoin('product_attribute_combination','pac','p.id_product_attribute = pa.id_product_attribute');	
			$r = Db::getInstance()->executeS($sql);
			if (count($r) > 0)
			{
				//We create an array of combinations, to perform changes on them from Actions later, by accessing them as $this->step->product_combinations[id_combination]
				foreach($r as $db_combination)
				{
					$n = new Combination($db_combination['id_product_attribute']);
					$this->product_combinations[$db_combination['id_product_attribute']] = $n;
				}
			}
			return $this;
		}

		/**
		 * [setCategories loads categories to perform work on them (moving products, reordering, whatever)]
		 * @param [type] $categories [description]
		 */
		public function setCategories($categories)
		{
			//Validate
			if (!is_array($categories))
				return false;
			foreach ($categories as $category)
			{
				if ( !is_int($category) )
					return false;
			}
			foreach ($categories as $category)
			{
				$this->categories[] = new Category($category,$this->lang);
			}
		}

	}
 ?>