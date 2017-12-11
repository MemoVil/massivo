<td>
	<table>
		<thead class="hidden">
			<tr class ="hidden">
				<th>
					{l s="Family of condition, based on short description" mod="massivo"}
				</th>
				<th>
					{l s="left text, based on long description" mod="massivo"}
				</th>
				<th>
					{l s="condition verb selector" mod="massivo"}
				</th>
				<th>
					{l s="right text long description" mod="massivo"}
				</th>
				<th>
					{l s="Buttons" mod="massivo"}
				</th>
			</tr>
		</thead>
		<tbody>
			<tr recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				<td>
					<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
						{foreach name=Conditionsbucle from=$step->getAllConditionsText() key=cpos item=text}
							<option value="{$text}">{l s="$text" mod="massivo"}</option>
						{/foreach}
					</select>
				</td>
				<td class="leftLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="rightLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
			</tr>
		</tbody>
	</table>
</td>
{literal}
	<script type="text/javascript" id="runConditionSelector">
		var recipeid = "{/literal}{$recipe->id}{literal}";
		var stepid = "{/literal}{$step->id}{literal}";
		var conditionid = "{/literal}{$condition}{literal}";
		$('.inputSelectCondition[recipe=' + recipeid + '][step=' + stepid + '][condition=' + conditionid + ']').on('change',
			function() {
				var selected = $(this).find("option:selected").val();
				var value = $(this).find("option:selected").attr('value');				
    			$.ajax({
		              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: {massivo_key: {/literal}"{$massivo_key}"{literal}, param: value, operation: 'getInputs', recipe: recipeid, step: stepid, condition: conditionid} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	console.log(xhr);
		              },
		              success:  function (response) {	              	
		              
	              }
	          	});
			}
		);
	</script>
{/literal}