<tr type="newcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">
	<td colspan="6" class="text-center subtablenewcondition">
		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" >
			<em>
				{l s="Press here to add a new condition" mod="massivo"}
			</em>
		</p>
	</td>			  			 
</tr>		  	
<script type="text/javascript" key="{$massivo_key}">
	{literal}
	$("table p.editable[recipe='"{/literal}{$recipe->id}{literal}'"][step='"{/literal}{$step->id}{literal}"'][row='"{/literal}{$row}{literal}']").unbind("click");
	$("table p.editable[recipe='"{/literal}{$recipe->id}{literal}'"][step='"{/literal}{$step->id}{literal}"'][row='"{/literal}{$row}{literal}']").click(
		function(event)
		{              			   
			var recipeid = el.attr('recipe');
			var stepid = el.attr('step'); 
			var massivokey = {/literal}"{$massivo_key}"{literal};
			var rowid = el.attr('row');
			var atad = { recipe: recipeid, step: stepid, massivo_key: massivokey, operation: 'displayConditionCreateMode', row: rowid};   
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
	              	var tr = $('tr[type='newcondition'][recipe=' + recipeid + '][step=' + stepid + '][row=' + rowid + ']');
	              	tr.replaceWith(response);	              	
	              }
          	});
		});
	}
	{/literal}
</script>