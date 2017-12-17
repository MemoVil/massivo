
	{literal}
	$('table p.editable[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}]').unbind("click");
	$('table p.editable[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}]').click(
		function(event)
		{              
			var el = $('tr[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');			   
			var recipeid = el.attr('recipe');
			var stepid = el.attr('step'); 
			var massivokey = {/literal}"{$massivo_key}"{literal};
			var rowid = el.attr('row');
			var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, operation: 'displayConditionCreateMode', row: rowid};   
			var jatad = { recipe: recipeid, step: stepid, massivo_key: massivokey, operation: 'getScript', script: 'displayConditionCreateMode', row: rowid};   
   			$.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: atad ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {	     
	              	var tr = $('tr.newcondition[type="newcondition"][recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']');
	              	tr.replaceWith(response);	      
           			$.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			jatad,
              			null,
              			'script'
          			);		              
	              }
          	});
		});
	
	{/literal}
