				<td>
					<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
						{foreach name=Conditionsbucle from=$step->getAllConditionsText() key=cpos item=text}
							<option value="{$cpos}">{l s="$text" mod="massivo"}</option>
						{/foreach}
					</select>
				</td>				
				<td class="leftLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="rightLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="inputParam" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
				</td>
				<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
						<button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}">
	    							<i class="icon-trash"></i>
        				</button>
        		        <span class="hiddenmodel hidden">   
					        <p class="text-center editable hidden" recipe="{$recipe->id}" step="{$step->id}" type="newcondition" param="{$step->conditions|@count}" >
									<em>
										{l s="Press here to add a new condition" mod="massivo"}
									</em>
							</p>
						</span>
				</td>				
{literal}
	<script type="text/javascript" class="runConditionSelector " {/literal}recipe="{$recipe->id}" step="{$step->id}" condition="{$condition}"{literal}>
		var recipeO = "{/literal}{$recipe->id}{literal}";
		var stepO = "{/literal}{$step->id}{literal}";
		var conditionid = "{/literal}{$condition}{literal}";
		var combo = $('.inputSelectCondition[recipe=' + recipeO + '][step=' + stepO + '][condition=' + conditionid + ']');
		combo.on('change',
			function() {
				var selected = $(this).find("option:selected").text();
				var value = $(this).find("option:selected").attr('value');				
    			$.ajax({
		              url: '{/literal}{$module_dir}{literal}' + "massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: {massivo_key: {/literal}"{$massivo_key}"{literal}, param: selected, operation: 'getConditionInput', recipeid: recipeO, stepid: stepO, condition: conditionid} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	console.log(xhr);
		              },
		              success:  function (response) {	              	
		              	combo.parent().nextAll().remove();
		              	combo.parent().after(response);
	            	 }
	          	});
		});
		$('button.canceladdaction[recipe=' + recipeO + '][step=' + stepO + '][condition=' + conditionid + ']').click(
		function(e){			
			$(this).parent().parent().html($('.hiddenmodel').clone().html());			
			var el = $('tr p.editable[type="newcondition"]');			
			clickControl = 1;
			el.removeClass('hidden');
			el.click(
				function(){
			 		attachEditableFunctionToStepList(el);					
				}
			);
		});
	</script>
{/literal}