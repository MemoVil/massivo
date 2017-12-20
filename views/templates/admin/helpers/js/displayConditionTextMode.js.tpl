{*<script>*}
	{literal}
	$('button.editstepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		function(){
		  	setObjectData({/literal}{$recipe->id}{literal},{/literal}{$step->id}{literal},{/literal}{$row}{literal});
			atad.operation = 'editStepCondition';			
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
	              }
          	});
		}		
	);
	$('button.deletestepcondition[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]').click(
		
	);
	{/literal}
{*</script>*}
