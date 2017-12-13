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
	    	<i class="icon-trash">  </i>
        </button>
	    <button type="button" class="btn btn-success saveaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
            {l s="Save" mod="massivo"}            
        </button>
        
</td>