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
	<input class="inputParam" type="text" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
</td>
<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	    <button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
	    	<i class="icon-trash">  </i>
        </button>
	    <button type="button" class="btn btn-success saveaction" recipe="{$recipe->id}" step="{$step->id}" condition="{$row}">
            {l s="Save" mod="massivo"}            
        </button>
        
</td>