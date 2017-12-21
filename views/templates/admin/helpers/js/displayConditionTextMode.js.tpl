{*<script>*}
	{literal}
	$('button.editstepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][cid="{/literal}{$condition->getId()}{literal}"]').click(
		function(){
		  	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'editStepCondition';			
			atad.cid = "{/literal}{$condition->getId()}{literal}";
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
              		$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').html(response);
              		jatad.script = 'displayConditionEditButtons';
              		jatad.cid = "{/literal}{$condition->getId()}{literal}";
	              	var r = $.get(
		              		"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              		jatad ,
		              		null,
		              		'script'
		             );
	              }
          	});
		}		
	);
	$('button.deletestepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"][cid="{/literal}{$condition->getId()}{literal}"]').click(
		function() {
			setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'deleteStepCondition';
			atad.cid = "{/literal}{$condition->getId()}{literal}";
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
		            	var t = response.split("$");
		             	if (t[0] == "Error")
	              			showError(t[1]);
		              	else {	          
		            		$('tr.stepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').remove();  		
		              	}              		
	              }
          	});

		}
	);
	{/literal}
{*</script>*}
