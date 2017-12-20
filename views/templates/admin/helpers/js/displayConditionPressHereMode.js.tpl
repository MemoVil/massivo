{*<script>*}
{literal}
	$('table p.editable[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		function(event)
		{              
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'displayConditionCreateMode';   			
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
	              	var tr = $('tr.newcondition[type="newcondition"][recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');	              	
	              	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});		
	              	tr.replaceWith(response);	
	              	jatad.operation = 'getScript';
					jatad.script = 'displayConditionCreateMode';         
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
{*</script>*}