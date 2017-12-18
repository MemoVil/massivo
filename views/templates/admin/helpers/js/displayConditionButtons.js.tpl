
	{literal}
	var el = $('td[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = {/literal}"{$massivo_key}"{literal};
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	var jatad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	$('button.canceladdcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			atad.operation = 'displayConditionPressHereMode';
			$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      				  //We load related script for such tr
				    jatad.operation = 'getScript';		    
				    jatad.script = atad.operation;
				    console.log(jatad);
		   			var r = $.get(
			          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
			          			jatad,
			          			null,
			          			'script'
				  			);	
		      			}
		    );

		}		   	
	);
	$('button.addcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			var cType = $('select.inputSelectCondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + '] option:selected').attr('value');
			var cVerb = $('select.inputSelectConditionVerb[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + '] option:selected').attr('value');
			var cParam = $('select.inputSelectConditionParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').attr('value');
			if (cParam == null)
				var cParam = ('input.inputParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').val();
			atad.operation = 'addStepCondition';
			atad.type = cType; atad.verb = cVerb;
			atad.param = cParam;
			$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);      				
      				jatad.operation = 'getScript';
				    jatad.script = atad.operation;
		   			var r = $.get(
	          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	          			jatad,
	          			null,
	          			'script'
		  			);		  
      			}
		    );
		   	atad.operation = 'displayConditionPressHereMode';
		  	atad.row = atad.row + 1;
		  	jatad.row = jatad.row + 1;
		  	jatad.script = atad.operation;
		  	var newRow = $.get(
	          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	          			atad,
	          			function(response){
							$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').parent().append(response);
						  	var r = $.get(
			          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
			          			jatad,
			          			null,
			          			'script'
				  			);
						},
	          			'html'
		  			);	
		}		   	
	);
	{/literal}
