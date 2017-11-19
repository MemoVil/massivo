<?php
	if (!defined('_PS_VERSION_'))
  		exit;
	class Trigger
	{
		/** @var INT id_script, INT name_script, INT order position, (Container of this trigger) */
		public $id_script; 
		public $name_script; 
		public $position;	
		public $id; /** One id, multiple positions */
		/**
		 * [$conditions Possible trigger types]
		 * @var array
		 */
		public static $schema = array(
			'attribute_group' => array('inGroup','notInGroup'),
			'attribute' => array('hasAttribute','hasNotAttribute'),
			'tag' => array('hasTag','hasNotTag'),
			'category' => array('inCategory','notInCategory'),
			'name' => array('equals','contains','notEqual','notContains')

		);
		public $conditions = array();
		/** [load Instead of a constructor, this helper class loads from an array its values] */
		public function load($t)
		{
			// If we have elements ...
			if (count($t) > 0)
			{
				$this->id = (int)$t['id'];
				$this->position = (int)$t['position'];
				$p = $t['conditions'];
				// We run through the array...
				foreach ($p as $i => $v)
				{
					//Each condition type must be fulfilled to perform the string
					//There could be more that a condition from same type, so we must order them each time
				}
			}
		}

	}
?>