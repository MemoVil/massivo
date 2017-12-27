{* <script type="text/javascript" key="{$massivo_key}"> *}
	// Time 0 -> Only first combo data (First load)
	// Time 1 -> Data loaded (Combo select)	
	{literal}
	var combo = $('.inputSelectAction[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	combo.on('change',
		function() {
			var selector = $(this).find("option:selected").text();
			var value = $(this).find("option:selected").attr('value');	
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.selected = selector;
			atad.operation = 'displayActionCreateMode';				
			atad.value = value;
			atad.time = "start";
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
	              	combo.parent().parent().replaceWith(response);
	              	combo = $('.inputSelectAction[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	              	atad.aid = combo.attr('aid');
	              	atad.value = combo.find("option:selected").attr('value');	              	
					atad.operation = 'displayActionCreateMode';						
	              	atad.time = 'actionDescription';              	
          			$('td.actionDescription[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
          				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php", 
          				 atad
          			);          			
              		jatad.script = 'displayActionCreateMode';
              		var inp = $('.aidValue[value="' + atad.aid + '"]');
              		jatad.type = inp.attr('type');              		
              		jatad.operation = 'getScript';              		
              		$('td.actionEditButtons[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
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
	$('button.canceladdaction[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][aid="{/literal}{$aid}{literal}"]').click(
		function(event) {
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'displayActionPressHereMode';
			$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][aid="{/literal}{$aid}{literal}"]').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				$(this).replaceWith(response);
      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
      				  //We load related script for such tr
				    jatad.operation = 'getScript';		    
				    jatad.script = 'displayActionPressHereMode';				    
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