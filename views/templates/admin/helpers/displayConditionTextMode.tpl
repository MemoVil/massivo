<tr class="stepcondition" type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" colspan="5">
	 		<p class="editable text-center" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" row="{$row}">
				{$condition->getFullDescription()}										
	 		</p>
	 	</td>	
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">				  			 			 		        
			<button type="button" class="btn btn-success editstepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			    <i class="icon-edit">  </i>
			</button>				    					
			<button type="button" class="btn btn-danger deletestepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			    <i class="icon-trash">  </i>
			</button>	    					
		</td>
</tr>
<script type="text/javascript" key="{$massivo_key}">
	{literal}
	var el = $('tr[recipe="{/literal}{$recipe->id}{literal}"][step="{/literal}{$step->id}{literal}"][row="{/literal}{$row}{literal}"]');	
	var recipeid = el.attr('recipe');
	var stepid = el.attr('step'); 
	var massivokey = {/literal}"{$massivo_key}"{literal};
	var rowid = el.attr('row');	
	var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, row: rowid};
	$('button.editstepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		function(){
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
              		$('tr.stepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').html(response);
	              }
          	});
		}		
	);
	$('button.deletestepcondition[recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']').click(
		
	);
	{/literal}
</script>