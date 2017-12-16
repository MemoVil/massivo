<tr type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">
	<td>
		<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			{foreach name=cbucle from=$step->getAllConditionsText() key=cpos item=text}
				<option value="{$cpos}">{l s="$text" mod="massivo"}</option>
			{/foreach}
		</select>
	</td>	
	<td class="leftLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="rightLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="inputParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		<button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			<i class="icon-trash"></i>
		</button>
	</td>		
</tr>
<script type="text/javascript" key="{$massivo_key}">
	// Time 0 -> Only first combo data (First load)
	// Time 1 -> Data loaded (Combo select)	
	{literal}
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = {/literal}"{$massivo_key}"{literal};
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	var combo = $('.inputSelectCondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']');
	combo.on('change',
		function() {
			var selector = $(this).find("option:selected").text();
			var value = $(this).find("option:selected").attr('value');	
			atad.selected = selector;
			atad.operation = 'displayConditionCreateMode';			
  			$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: atad ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {		              	
          			$('td.leftLongConditionDescription[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
          				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",          				
          				 atad.time = 'left',
          				 function(response) {
          				 	doEval(response);
          				 } 
          			);

              		$('td.inputSelectConditionVerb[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
              				 atad.time = 'verb',
	          				 function(response) {
	          				 	doEval(response);
	          				 } 
              			);
              		$('td.rightLongConditionDescription[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
          				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
          				 atad.time = 'right',
          				 function(response) {
          				 	doEval(response);
          				 } 
          			);
              		$('td.inputParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
              				 atad.time = 'param',
	          				 function(response) {
	          				 	doEval(response);
	          				 } 
              			);
              		$('td.conditionButton[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              			{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
              			atad.time = 'buttons',
          				 function(response) {
          				 	doEval(response);
          				 } 
              		);	              	
	              	              	
	              }
          	});
		}
	);
	$('button.canceladdcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(event) {
			atad.operation = 'displayConditionPressHereMode';
			$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
  				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      			}
		    );
		}		   	
	);
	{/literal}
</script>