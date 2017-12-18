{* <script type="text/javascript" key="{$massivo_key}"> *}
	// Time 0 -> Only first combo data (First load)
	// Time 1 -> Data loaded (Combo select)	
	{literal}
	var el = $('tr[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');	
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = "{/literal}{$massivo_key}{literal}";
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	var jatad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid, operation: 'getScript'}; 
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
	              	atad.time = 'left';              	
          			$('td.leftLongConditionDescription[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
          				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php", 
          				 atad
          			);
          			atad.time = 'verb';
              		$('td.inputSelectConditionVerb[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              				atad
              			);
              		atad.time = 'right';
              		$('td.rightLongConditionDescription[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
          				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
          				 atad
          			);
          			atad.time = 'param';
              		$('td.inputParam[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              				 atad
              			);
              		atad.time = 'buttons';
              		jatad.script = 'displayConditionButtons';
              		$('td.conditionButton[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').load(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			atad,
              			function(response) {
		           			$.get(
		              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              			jatad,
								null,
		              			'script'
	              			);	
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
	{/literal}
{*</script>*}