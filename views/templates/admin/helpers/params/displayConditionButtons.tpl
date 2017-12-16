<button type="button" class="btn btn-danger canceladdcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	<i class="icon-trash"></i>
</button>
<button type="button" class="btn btn-success addcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
    <i class="icon-check"></i>
</button>     
<script type="text/javascript" key="{$massivo_key}">
	{literal}
	var el = $('td[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = {/literal}"{$massivo_key}"{literal};
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	$('button.canceladdcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			atad.operation = 'displayConditionPressHereMode';
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
      				doEval(response);
      			}
		    );
		}		   	
	);
	{/literal}
</script>