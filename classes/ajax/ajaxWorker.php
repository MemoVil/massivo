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
				ddd($key . ' ' .$value);				
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
				if ($this->postLength('param','1'))		
				 {
				 	return $this->triggerNewRecipe($this->post['param']);						
				 }
				 else $this->error('Error: Recipe name is too short');
			break;
			case "refreshRecipes":
				return $this->displayAllRecipes();
			break;	
			case "loadSteps":
				return $this->displayCreateTabStepsForm($this->post['param']);
			break;
			case "addBlankStep":								
				$r = Recipe::load($this->post['recipe']);		

				if ( $h = $this->addBlankStep($r,$this->post['step']) )
				{
					$this->success('Step added$' . $this->post['step'] . '$' . $h);
				}
				else  $this->error('Error: An error appeared during step addition');
			break;
			case 'renameRecipe':
				$r = Recipe::load($this->post['recipeid']);
				if (strcmp($this->post['param'],$this->post['recipeid']) != 0)
				{
					$r->name = $this->post['param'];
					$r->save();
					$this->success('Recipe name changed');
				}
				else $this->error('Error: Same name or ilegal newname');
			break;
			case 'deleteRecipe':
					$r = Recipe::deleteById($this->post['recipeid']);		
					if ($r)
						$this->success('Recipe ' . $this->post['recipeid'] . ' deleted');
					else
						$this->error('Error: There was an error while removing recipe');
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
			case 'displayConditionCreateMode': 
				if ($this->arePost('row','step','recipe'))
				{					
					$h = new HelperMassivo();
					if ($this->post['time'])
					{
						switch ($this->post['time'])
						{							
							case 'verb':							
							case 'param':
							case 'buttons':
							case 'type':
							case 'left':
							case 'right':
								$p = $this->post['selected'];
								$r = Recipe::load($this->post['recipe']);
			        			$s = $r->getStepById($this->post['step']);   
								foreach ($s->getDeclaredConditions() as $class)
								{
									$c = new $class($s);
									if (strcmp($c->conditionDescription['short_description'],$p) == 0 )
									{
										$this->post['condition'] = $c;																				
										//Extend tpl control
										if (method_exists($c,$this->post['operation']))
										{
											$tpl = call_user_func(array($c,$this->post['operation']),$this->post);
											if ($tpl) 
											{
												echo $tpl;
												continue;
											}
										}
									}
								}
							break;
						}
					}
					else $this->post['time'] = 'start';
					//Time is the switcher on helper					
					$r = $h->displayConditionCreateMode($this->post);
					echo $r;
				}
			break;
			case 'displayConditionPressHereMode':
				if ($this->arePost('row','step','recipe'))
				{
					$h = new HelperMassivo();
					$r = $h->displayConditionPressHereMode($this->post);
					echo $r;
				}
			break;
			case 'addStepCondition':								
				if ($this->arePost('type','recipe','step','row','verb','param') && $this->postLength('1'))
				{						
					$c = $this->addNewCondition($this->post);
					$h = new HelperMassivo();
					if ( !$c ) 
					{						
						$o = $this->error('Error: Error adding new condition');						
						$o .= $h->displayConditionCreateMode($this->post);
						return $o;
					}			
					$this->post['condition'] = $c;					
					$this->post['cid'] = $c->id;					
					$o = $h->displayConditionTextMode($this->post);
					$this->post['row']++;
					$o .= $h->displayConditionPressHereMode($this->post);
					echo $o;
				}				
				else  {					
					if (!$this->postLength('param','1'))
						$error[] = '<p>Error: We need a param for this condition</p>';
					if (!$this->postLength('row','1'))
						$error[] = '<p>Error: Error while attaching condition to this step</p>';
					if (!$this->post['type'])
						$error[] = '<p>Error: Condition type not specified or not found</p>';
					$this->error(implode(PHP_EOL,$error));
				}
			break;
			case 'editStepCondition':
								
				if ($this->arePost('row','step','recipe','cid'))
				{					
					$r = Recipe::load($this->post['recipe']);
					$s = $r->getStepById($this->post['step']);
					$c = $s->getConditionById($this->post['cid']);	
					//Extend tpl control
					if (method_exists($c,$this->post['operation']))
					{
						$tpl = call_user_func(array($c,$this->post['operation']),$this->post);
						if ($tpl) 
						{
							echo $tpl;
							continue;
						}
					}

					$this->post['condition'] = $c;					
					$h = new HelperMassivo();
					$this->post['time'] = 'type';
					$o = $h->displayConditionCreateMode($this->post);
					$this->post['time'] = 'left';
					$o .= $h->displayConditionCreateMode($this->post);
					$this->post['time'] = 'verb';
					$o .= $h->displayConditionCreateMode($this->post);
					$this->post['time'] = 'right';
					$o .= $h->displayConditionCreateMode($this->post);
					$this->post['time'] = 'param';
					$o .= $h->displayConditionCreateMode($this->post);
					$this->post['time'] = 'editbuttons';
					$o .= $h->displayConditionCreateMode($this->post);
					echo $o;
				}
			break;
			case 'getScript':		
				if ($this->arePost('row','step','script','recipe'))
				{
					$h = new HelperMassivo();
					$r = Recipe::load($this->post['recipe']);
					$s = $r->getStepById($this->post['step']);
					
					if ($this->arePost('aid','type'))
					{
						$a = new $this->post['type']($s);
						$a->id = $this->post['aid'];
						
						//Extended tpl control for actions
						if (method_exists($a,$this->post['operation']))
						{							
							$tpl = $a->{$this->post['operation']}($this->post);						
							if ($tpl) 
							{
								echo $tpl;
								continue;
							}
						}
					}	
					$o = $h->getScript($this->post);
					echo $o;					
				}
			break;
			case 'saveEditStepCondition':
				if ($this->arePost('row','step','recipe','cid') && $this->postLength('1'))
				{
					$r = Recipe::load($this->post['recipe']);
					$s = $r->getStepById($this->post['step']);
					$c = $s->getConditionById($this->post['cid']);	
					if ($this->arePost('verb','type','param'))
					{					
						$nc = new $this->post['type']($s);
						$nc->type  = $this->post['type'];
						$nc->condition = $this->post['verb'];
						$nc->param = $this->post['param'];
						$nc->id = $c->id;						
						$s->conditions[$s->findCondition($c)] = $nc;										 
						$r->save();
						if (method_exists($nc,$this->post['operation']))
						{
							$tpl = call_user_func(array($nc,$this->post['operation']),$this->post);
							if ($tpl) 
							{
								echo $tpl;
								continue;
							}
						}
						$h = new HelperMassivo();						
						$o = $h->displayConditionTextMode($this->post);
						echo $o;
					}
				}
				else  {					
					if (!$this->postLength('param','1'))
						$error[] = '<p>Error: We need a param for this condition</p>';
					if (!$this->postLength('row','1'))
						$error[] = '<p>Error: Error while attaching condition to this step</p>';
					if (!$this->post['type'])
						$error[] = '<p>Error: Condition type not specified or not found</p>';
					$this->error(implode(PHP_EOL,$error));
				}

			break;
			case 'displayConditionTextMode':
				if ($this->arePost('row','step','recipe','cid'))
				{					
					$r = Recipe::load($this->post['recipe']);
					$s = $r->getStepById($this->post['step']);
					$c = $s->getConditionById($this->post['cid']);	
					if (method_exists($c,$this->post['operation']))
					{
						$tpl = call_user_func(array($c,$this->post['operation']),$this->post);
						if ($tpl) 
						{
							echo $tpl;
							continue;
						}
					}
					$h = new HelperMassivo();					
					$o = $h->displayConditionTextMode($this->post);
					echo $o;
				}
			break;
			case 'deleteStepCondition':
			{
				if ($this->arePost('row','step','recipe','cid'))
				{
					$r = Recipe::load($this->post['recipe']);
					$s = $r->getStepById($this->post['step']);
					$c = $s->getConditionById($this->post['cid']);						
					if ( !$s->removeCondition($c->getId()) )
						$this->error('Error: Condition was not deleted');
					else
					{
						$r->save();
						$this->success('Condition deleted');
					}
				}
			}
			break;
			case 'displayActionCreateMode': 
				if ($this->arePost('row','step','recipe'))
				{					
					$h = new HelperMassivo();

					if ($this->post['time'])
					{
						$r = Recipe::load($this->post['recipe']);
						$s = $r->getStepById($this->post['step']);  
						switch ($this->post['time'])
						{		
							case 'start':									
								$enabledActions = $s->getUnlockedActions();	
			        			if (count($enabledActions) == 0)        		
			        			{
			        				$this->error("Actions are related to conditions, so you can't add an action if no condition is set");			      
			        				return;  				
			        			}						
								if ($this->arePost('action') && $this->post['action'] !== 'newaction')
								{
									$p = $this->post['selected'];									
				        			$enabledActions = $s->getUnlockedActions();	
				        			
									foreach ($enabledActions as $class)
									{
										$a = new $class($s);
										if ($a->isLocked($s->conditions))
											continue;
										if (strcmp($a->actionDescription['short_description'],$p) == 0 )
										{		
											$this->post['action'] = $a;											
											$this->post['aid'] = $a->getId();																
											//Don't need fake override on start, just show it in the combo
										}
									}
								}
								else if ($this->arePost('type')) 
								{									
				        			$a = new $this->post['type']($s);
									$this->post['aid'] = $a->getId();
									$this->post['action'] = $a;
								}
							break;
							case 'actionDescription':									
			        			if (!isset($this->post['type'])) 			        				
			        				return;	
			        			$a = new $this->post['type']($s);
								$a->id = $this->post['aid'];
								$this->post['action'] = $a;
								if (method_exists($a,$this->post['operation']))
								{
									$tpl = $a->{$this->post['operation']}($this->post);
									if ($tpl && strlen($tpl) > 0) 
									{
										echo $tpl;
										break(2);
									}
								}
			        		break;
						}
					}
					else {						
						 $this->post['time'] = 'start';
					}
					//Time is the switcher on helper	
					if (!$this->arePost('aid'))	
						$this->post['aid'] = '';
					$r = $h->displayActionCreateMode($this->post);
					echo $r;
				}
			break;
		}
	}
	/**
	 * [addNewCondition Adds a new Condition]
	 * @param [type] $post [description]
	 */
	public function addNewCondition($post)
	{
		$r = Recipe::load($post['recipe']);
		if (!$r )
			return false;
		if ($s = $r->getStepById($post['step']))
		{
			$c = $s->addCondition(
				$post['type'],
				$post['verb'],
				$post['param'],
				$r->lang
			);			
			$r->save();
			return $c;
		}
		return false;
	}
	/**
	 * [editCondition Edits an existing condition]
	 * @param  [type] $post [description]
	 * @return [type]       [description]
	 */
	public function editCondition($post)
	{
		$r = Recipe::load($post['recipe']);
		if (!$r )
			return false;
		if ($s = $r->getStepById($post['step']))
		{
			$c = $s->getCondition($post['condition']);
			return $c;
		}
		return false;
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
		else $this->error('Error while adding new recipe');		
		return true;
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
		$h = new HelperMassivo();
		$tpl = $h->displayAddBlankStep($recipe,$s);		
		$recipe->save();		
		return $tpl;	
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

if ($_SERVER['REQUEST_METHOD'] === 'GET')
{	
	if (!$ajax->validatePost($_GET)) {					
		$ajax->displayError();		
	}
	else {		
		$ajax->load($_GET);
		$ajax->run($debug);		
	}
}
elseif ( !$ajax->validatePost($_POST)  ) 
{
	$ajax->displayError();	
}
else {
	$ajax->load($_POST);
	$ajax->run($debug);
	//$ajax->debug();	
}


?>