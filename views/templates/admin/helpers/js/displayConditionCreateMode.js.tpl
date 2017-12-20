{* <script type="text/javascript" key="{$massivo_key}"> *}
	// Time 0 -> Only first combo data (First load)
	// Time 1 -> Data loaded (Combo select)	
	{literal}
	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
	var combo = $('.inputSelectCondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	combo.on('change',
		function() {
			var selector = $(this).find("option:selected").text();
			var value = $(this).find("option:selected").attr('value');	
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
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
	              	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
	              	atad.selected = selector;
					atad.operation = 'displayConditionCreateMode';						
	              	atad.time = 'left';              	
          			$('td.leftLongConditionDescription[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
          				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php", 
          				 atad
          			);
          			atad.time = 'verb';
              		$('td.inputSelectConditionVerb[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
              				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              				atad
              			);
              		atad.time = 'right';
              		$('td.rightLongConditionDescription[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
          				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
          				 atad
          			);
          			atad.time = 'param';
              		$('td.inputParam[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
              				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              				 atad
              			);
              		atad.time = 'buttons';
              		jatad.script = 'displayConditionButtons';
              		jatad.operation = 'getScript';
              		$('td.conditionButton[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
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
		});
	$('button.canceladdcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		function(event) {
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'displayConditionPressHereMode';
			$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
      				  //We load related script for such tr
				    jatad.operation = 'getScript';		    
				    jatad.script = 'displayConditionPressHereMode';				    
		   			var r = $.get(
			          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
			          			jatad,
			          			null,
			          			'script'
				  			).fail(
				  				function(s,r,o)	{
				  					console.log(o);
				  				}
				  			);	
		      		}

		    );

		}		   	
	);
	{/literal}
{*</script>*}