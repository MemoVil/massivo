{* <script> *}
	{literal}
	$('button.canceladdcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		function(event) {
			var el = $('td[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
			atad.operation = 'displayConditionPressHereMode';
			$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
      				var t = response.split('$');
      				if (t[0] == 'Error')
      				{
      					showError(t[1]);
      				}
      				$(this).replaceWith(response);
      				  //We load related script for such tr
      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
				    jatad.operation = 'getScript';		    
				    jatad.script = 'displayConditionPressHereMode';				    
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
	$('button.addcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		function(event) {
			var cType = $('select.inputSelectCondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"] option:selected').attr('value');
			var cVerb = $('select.inputSelectConditionVerb[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"] option:selected').attr('value');
			var cParam = $('select.inputSelectConditionParam[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').attr('value');
			if (cParam == null)
				var cParam = $('input.inputParam[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').val();
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
			atad.operation ='addStepCondition';
			atad.type =cType;
			atad.verb =cVerb;
			atad.param =cParam;
			var r = $.get(
				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response) {
	      				var t = response.split('$');
	      				if (t[0] == 'Error')
	      				{
	      					showError(t[1]);
	      					return;
	      				}
	      				$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').replaceWith(response);
	      				var cid = $('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').attr('cid');

	      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});	

      				    jatad.operation = 'getScript';
      				    jatad.cid = cid;
					    jatad.script ='displayConditionTextMode' ;
	    	   			var r = $.get(
		          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		          			jatad,
		          			null,
		          			'script'
			  			); 					  	
					  	jatad.row = parseInt(jatad.row) + 1;
					  	jatad.script = 'displayConditionPressHereMode';
					  	var r = $.get(
				          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
				          			jatad,
				          			null,
				          			'script'
					  	);				  	
					  	r.error(
          				function(o,text,error) {
          					console.log(error);
          				});  
      			},
      			'html'
			);
			return;	  	
		}		   	
	);
	{/literal}
{* </script> *}