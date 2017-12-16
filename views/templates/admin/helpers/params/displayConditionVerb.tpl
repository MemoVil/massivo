<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	<select class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		{foreach name=Verbbucle from=$condition->getVerb() key=cverb item=verb}
			<option value="{$cverb}"
				 {if $verb|trim == $condition->getCondition()|trim} selected {/if}
				>
				{l s="$verb" mod="massivo"}
			</option>
		{/foreach}
</select>
</td>