{*<script> *}
	{literal}
	$('button.canceleditcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][cid="{/literal}{$condition->getId()}{literal}"]').click(
		function(event) {
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
			atad.operation = 'displayConditionTextMode';
			atad.cid = "{/literal}{$condition->getId()}{literal}";
			var tr = $('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][cid="{/literal}{$condition->getId()}{literal}"]');
			tr.load(
  				"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
      			atad,
      			function(response)
      			{
					var t = response.split('$');
      				if (t[0] == 'Error')
      				{
      					showError(t[1]);
      					return;
      				}
      				$(this).replaceWith(response);
      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
				    //We load related script for such tr
				    jatad.operation = 'getScript';
				    jatad.script = 'displayConditionTextMode';
				    jatad.cid = "{/literal}{$condition->getId()}{literal}";
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
	$('button.saveeditcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][cid="{/literal}{$condition->getId()}{literal}"]').click(
		function(event) {
			var cType = $('select.inputSelectCondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"] option:selected').attr('value');
			var cVerb = $('select.inputSelectConditionVerb[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"] option:selected').attr('value');
			var cParam = $('select.inputSelectConditionParam[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').attr('value');
			if (cParam == null)
				var cParam = $('input.inputParam[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').val();			
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation ='saveEditStepCondition';
			atad.type =cType;
			atad.verb =cVerb;
			atad.param =cParam;
			atad.cid = "{/literal}{$condition->getId()}{literal}";
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
	      				setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
      				    jatad.operation = 'getScript';
					    jatad.script = 'displayConditionTextMode';
					    jatad.cid = "{/literal}{$condition->getId()}{literal}";
	    	   			var r = $.get(
		          			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		          			jatad,
		          			null,
		          			'script'
			  			);
      			},
      			'html'
			);
			return;	  	
		}		   	
	);
	{/literal}

{*</script>*}