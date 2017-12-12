<?php 
include_once('../../../../config/config.inc.php');
include_once('../../../../init.php');
include_once(_PS_MODULE_DIR_.'massivo/includes/scription.php');
include_once(_PS_MODULE_DIR_.'massivo/classes/Recipe.php');
//On this class we will generate our custom forms for module
include_once(_PS_MODULE_DIR_.'massivo/classes/HelperMassivo.php');
$debug = true;

class DATA {
	/** 
	*	const for post-access from Ajax-Worker
	* 	Usage: DATA::COMBINATIONS
	* 
	*/
	const	COMBINATION = _DB_PREFIX_ . 'product_attribute';
	const	PRODUCTCOMBINATIONDETAIL = _DB_PREFIX_ . 'product_attribute_combination';
	const	PRODUCTDESCRIPTION = _DB_PREFIX_ . 'product_lang';
	const	PRODUCTTAG  = _DB_PREFIX_ . 'product_tag';
	const	PRODUCT = _DB_PREFIX_ . 'product';
	const	ATTRIBUTE = _DB_PREFIX_ . 'attribute';
	const	ATTRIBUTEGROUP = _DB_PREFIX_ . 'attribute_group';
	const	ATTRIBUTELANG = _DB_PREFIX_ . 'attribute_lang';
	const	ATTRIBUTEGROUPLANG = _DB_PREFIX_ . 'attribute_group_lang';
}
class AjaxWorker extends ModuleAdminController {
	/** Trait to gain Script Manager Habilities */
	use scription;
	/**
	 * @var $safe, public. State true if $post has been validated
	 */
	public $safe = false;
	
	/**
	 * @var intEcho, just for debugging purposes
	 */
	public $intEcho = 1;
	public $header ='Content-Type: application/json';
	public $post = array();
	public $debug = false;
	public $keys = array('reference','ean13','upc','canonic_product','price','wholesale_price','quantity','weigth','location','ecotax');
	
	/**
	 * Validate $post to avoid XSS and dumb entries
	 * @param type $post 
	 * 
	 * @return true if valid, false if unvalid. 
	 * 
	 */ 
	public function __construct()
	{
		$this->context = Context::getContext();
	}

	public function validatePost($post)
	{		
		$massivoKey = Configuration::get('massivo_key');
		if (array_key_exists('massivo_key', $post))
		{			
			if ( strcmp($post['massivo_key'], $massivoKey) === 0 )
			{
				$this->safe = true;
				$this->intEcho += 10;				
			}
		}

		foreach($post as $key => $value)
		{		
			if ($this->isLegal($value))
			{
				$this->intEcho += 10; 
			}
			else
			{
				ddd($value);				
				$this->safe = false;
				$this->intEcho = -1;
			}
		}		
		return $this->safe;
	}
	public function verifyReference($reference)
	{
		return preg_match('/[^a-z_\-0-9\/]/i',$reference);
	}


	/**
	 * Load ajax array submited via post.
	 * Verifies $key is alpha and $value is valid for each element on the array
	 * 
	 * @param type $post 
	 * @return type
	 */
	public function load($post)
	{
		foreach ($post as $key=>$value)
		{
			$key = strtolower($key);
			if (Validate::isModuleName($key) && $this->isLegal($value))
			$this->post[$key] = $value;
		}
	}

	/**
	 * setAttributeReference, sets Reference (SKU) for a combination
	 * @param combination, unique id of a combination
	 * @param array reference, new reference or value to set
	 * 			type = (canonic_product, ean13, upc,...)
	 * @param debug, use true if you want to output result
	 * @return false on error
	 * @return false if Attribute doesn't exist 
	 */
	public function setAttribute($combination, $reference, $debug = false)
	{		
		if (!Validate::isInt($combination) 
			|| !Validate::isString($reference['param'])
			|| !in_array($reference['type'], $this->keys)
			)
			{			
				return false;
			}	

		// We check if provided combination already exist. If not, we can't just add it here
		$sql = sprintf("SELECT COUNT(*) from %s where id_product_attribute = '%s'",DATA::COMBINATION,$combination);
		$result = DB::getInstance()->getValue($sql);
		
		if ($result == 0)
		{
			return false;
		}
		//We must escape param from user
		$sql = sprintf("UPDATE %s set %s = '%s' where id_product_attribute = '%s' LIMIT 1", DATA::COMBINATION, $reference['type'], pSQL($reference['param']), $combination);
		if (!DB::getInstance()->execute($sql))
		{
			$this->post['lasterror'] = DB::getInstance()->getMsgError();
			if ($debug)
			{
				$this->debug();
				return false;
			}
			return false;
		}	
		return true;
	}
	/**
	 * Main method, Executes POST and returns info
	 * @return type
	 */
	public function run($debug)
	{
		$post = $this->post;
		switch ($this->post['operation'])
		{
			case "update":		
				foreach ($this->keys as $key)
				{			
					if (in_array($key,$post))
					{					
						$reference = array (
										'param' => $post['val'],
										'type' => $key
									);
						if ($this->setAttribute($post['combination'],$reference,$debug))
						{
							//Si la combinacion se ha fijado correctamente devolvemos un OK
							header($this->header);
							echo 'OK';
						}	
						else $this->debug();
						return;
					}
				}
			break;
			case "tab":
				return $this->runTab($this->post['tab']);
			case "addRecipe":				
				return $this->triggerNewRecipe($this->post['param']);						
			break;
			case "refreshRecipes":
				return $this->displayAllRecipes();
			break;	
			case "loadSteps":
				return $this->displayCreateTabStepsForm($this->post['param']);
			break;
			case "addBlankStep":								
				$r = Recipe::load($this->post['recipeid']);		

				if ( $s = $this->addBlankStep($r,$this->post['step']) )
				{
					$this->success('Step added$' . $this->post['step'] . '$' . $s->id);
				}
				else  $this->error('An error appeared during step addition');
			break;
			case 'renameRecipe':
				$r = Recipe::load($this->post['recipeid']);
				if (strcmp($this->post['param'],$this->post['recipeid']) != 0)
				{
					$r->name = $this->post['param'];
					$r->save();
					$this->success('Recipe name changed');
				}
				else $this->error('Similar or ilegal newname');
			break;
			case 'deleteRecipe':
					$r = Recipe::deleteById($this->post['recipeid']);		
					if ($r)
						$this->success('Recipe ' . $this->post['recipeid'] . ' deleted');
					else
						$this->error('There was an error while removing recipe');
			break;
			case 'deleteSteps':
				$r = Recipe::load($this->post['recipeid']);	
				$ok = $r->deleteSteps(trim($this->post['param']));
				$this->success($ok . ' Steps  deleted.');				
			break;
			case 'displayNewActionSelector':
				$h = new HelperMassivo();
				$r = $h->displayNewActionSelector($this->post);
				echo $r;
			break;
			case 'displayActionSelector':
				$h = new HelperMassivo();
				$r = $h->displayActionSelector($this->post);
				echo $r;
			break;
			case 'displayNewConditionSelector':
				$h = new HelperMassivo();		
										
				$r = $h->displayNewConditionSelector($this->post);
				echo $r;
			break;
			case 'displayConditionSelector':
				$h = new HelperMassivo();
				$r = $h->displayConditionSelector($this->post);
				echo $r;
			break;
			case 'getConditionInput':
					//Param is text on input selector
					if ($this->post['param'])
					{
						$r = Recipe::load($this->post['recipe']);
						$s = $r->getStepById($this->post['step']);   
						//We compare Param with all short descriptions on all conditions   
						$this->post['recipe'] = $r;
						$this->post['step'] = $s;
						foreach($s->getDeclaredConditions() as $class)
						{
							$c = new $class($s);
							if (strcmp($c->conditionDescription['short_description'],$this->post['param']) == 0 )
							{
								$h = new HelperMassivo();
								$ret = $h->displayConditionInput($c,$this->post);
								echo $ret;
							}
						}				
					}
			break;

		}
	}
	public function displayCreateTabStepsForm($recipe)
	{
		$recipe = (int)$recipe;
		if (!$r = Recipe::existById($recipe))
		{			
			$this->displayError();
			return;
		}
		$o = Recipe::load($recipe);				
		$h = new HelperMassivo();		
		$form = $h->load('CreateTabStepsForm',$o);

		echo $form;
	}
	/**
	 * Deprecated
	 * [runTab Generates bootstrap forms and refills them on tab click]
	 * @param  String $tab [description]
	 * @return [type]       [description]
	 */
	public function runTab($tab = 'editTab')
	{
		switch ($tab)
		{
			case 'editTab': 
		}
		return;		
	}
	public function triggerNewRecipe($newRecipe)
	{
		if ($recipe = $this->addRecipe($newRecipe))
		{			
			$display = $this->displayAppendRecipe(
				$recipe
			);		
			echo $display;	
			return true;
		}
		else;
			//Echo Warning
		return;
	}
	/**
	 * [addRecipe adds a new Recipe called $name to database, without steps]
	 * @param [String] $name [new Recipe name]
	 * @return  Recipe or false
	 */
	public function addRecipe($name)
	{
		$id = Recipe::exist($name);				
		if ($id == 0)
		{			
			$newRecipe = new Recipe();			
			$newRecipe->name = pSQL($name);
			$newRecipe->id = $this->getTime();						
			$newRecipe->save();
			return $newRecipe;
		}
		else return false;
	}
	/**
	 * [addStep adds a blank Step to $recipe]
	 * @param [Recipe] $recipe [description]
	 * @param [String] $step   [description]
	 */
	public function addBlankStep($recipe,$step)
	{		
		if (get_class($recipe) != "Recipe")
			return false;
		if (strlen($step) < 2 )
			$step = $this->generateRandomString();
		$s = new Step();
		$s->name = $step;
		$s->recipe = $recipe;
		$recipe->addStep($s);
		$recipe->save();		
		return $s;	
	}

	/**
	 * [displayAllRecipes Designed to overwrite recipelist id on content tab]
	 * direct echo via ajax
	 */
	public function displayAllRecipes()
	{
		$this->context->smarty->assign(
			'recipes',  $this::getScripts(),
			'lang', $this->context->language->id
		);
		$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayAllRecipes.tpl');
		echo $tpl;
	}
	/**
	 * [displayAppendRecipe appends a recipe to recipe list]
	 * @param  [type] $recipe [description]
	 * @return [type]         [description]
	 */
	public function displayAppendRecipe($recipe)
	{			
		$this->context->smarty->assign(
			array(
				'id' => $recipe->id,
				'text' => $recipe->name,
				'pos' => count($this::getScripts())
			)
		);

		$tpl = $this->context->smarty->fetch(_PS_MODULE_DIR_ . 'massivo/views/templates/admin/displayCard.tpl');		
		return $tpl;
	}
	/**
	 * Display error message. Halt.
	 * 
	 * @return none	 */

	public function displayError()
	{
		header($this->header);
		echo "Invalid access";	
	}

	/**
	 * Print debug information about loaded vars
	 * 
	 * @return none, just print info
	 */
	public function debug() 
	{
		header($this->header);
		ppp($this->post);
	}

}
$ajax = new AjaxWorker();

if ( !$ajax->validatePost($_POST) ) 
{
	$ajax->displayError();	
}
else {
	$ajax->load($_POST);
	$ajax->run($debug);
	//$ajax->debug();	
}


?>