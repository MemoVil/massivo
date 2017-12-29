{* <script type="text/javascript" key="{$massivo_key}"> *}
	// Time 0 -> Only first combo data (First load)
	// Time 1 -> Data loaded (Combo select)	
	{if $time == 'start' || $time == null}
	{literal}
	var combo = $('.inputSelectAction[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	combo.on('change',
		function() {
			var selector = $(this).find("option:selected").text();
			var value = $(this).find("option:selected").attr('value');	
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.selected = selector;
			atad.operation = 'displayActionCreateMode';				
			atad.type = value;
			atad.time = "actionDescription";
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
	              	$('.' + atad.time).replaceWith(response);
	              	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
	              	atad.selected = selector;	              	
	              	combo = $('.inputSelectAction[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
	              	atad.aid = combo.attr('aid');
	              	atad.type = combo.find("option:selected").attr('value');	              	
					atad.operation = 'displayActionCreateMode';						
	              	atad.time = 'actionDescription';              	
          			//$('td.actionDescription[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
          			//	"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php", 
          			//	 atad
          			//);          			
              		jatad.script = 'displayActionCreateMode';
              		var inp = $('.aidValue[value="' + atad.aid + '"]');
              		jatad.type = combo.find("option:selected").attr('value');	
              		jatad.selected = selector;                       		  		
              		jatad.aid = atad.aid;
              		jatad.operation = 'getScript';    
              		jatad.time = 'actionDescription';
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
	{/if}
{*</script>*}