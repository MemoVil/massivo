
	{literal}
	var el = $('td[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = {/literal}"{$massivo_key}"{literal};
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	$('button.canceleditcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			atad.operation = 'displayConditionTextMode';
			var tr = $('tr.stepcondition[recipe="' + recipeid + '"][step="' + stepid + '"][row="' + rowid + '"]');
			tr.load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      				doEval(response);
      			}
		    );
		}		   	
	);
	$('button.saveeditcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			var cType = $('select.inputSelectCondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + '] option:selected').attr('value');
			var cVerb = $('select.inputSelectConditionVerb[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + '] option:selected').attr('value');
			var cParam = $('select.inputSelectConditionParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').attr('value');
			if (cParam == null)
				var cParam = ('input.inputParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').val();
			atad.operation ='saveEditStepCondition';
			atad.type =cType;
			atad.verb =cVerb;
			atad.param =cParam;
			$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      				doEval(response);
      			}
		    );
		}		   	
	);
	{/literal}

