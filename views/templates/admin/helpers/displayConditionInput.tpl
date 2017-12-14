<td class="leftLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	{$condition->getLeftText()}
</td>
<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	<select class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
		{foreach name=Verbbucle from=$condition->getVerb() key=cverb item=verb}
			<option value="{$cverb}">{l s="$verb" mod="massivo"}</option>
		{/foreach}
	</select>
</td>
<td class="rightLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	{$condition->getRightText()}
</td>
<td class="inputTextTd" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	{assign var=getSelectable value=$condition->getSelectable()|@count} 
	{if $getSelectable > 0}	
		<select class="inputSelectConditionParam" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
			{foreach name=selectablebucle from=$condition->getSelectable() key=csel item=select}					
					<option value="{$select['id']}"> {$select['public']}</option>
			{/foreach}
		</select>
	{else}
	<input class="inputParam" type="text" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	{/if}
</td>
<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	    <button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	    	<i class="icon-trash"></i>
        </button>
	    <button type="button" class="btn btn-success saveaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
            <i class="icon-check"></i>
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
	<script type="text/javascript" class="triggerButtons " {/literal}recipe="{$recipe->id}" step="{$step->id}" condition="{$row}"{literal}>
	$('button.canceladdaction').click(
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
		}
	);
	$('button.saveaction').click(
		function(e) {
			var rId = $(this).attr('recipe'); var sId = $(this).attr('step'); var cId = $(this).attr('condition');
			if ( rId > 0 && sId > 0  && cId >= 0 )
			{
				var cType = $('select.inputSelectCondition option:selected').attr('value');
				var cVerb = $('select.inputSelectConditionVerb option:selected').attr('value');
				var cParam = $('select.inputSelectConditionParam').attr('value');
				if ( cParam == null)
				{
					cParam = $('inputParam').val();
				}
				$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: {massivo_key: {/literal}"{$massivo_key}"{literal}, operation: 'addCondition', recipeid: rId, stepid: sId, condition: cId,	type: cType, verb: cVerb, param: cParam} ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {	              	
	              
	              }
	          	});
			}
		}
	);
	</script>
{/literal}