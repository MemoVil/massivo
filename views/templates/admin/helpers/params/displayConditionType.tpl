<td class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" cid='{$cid}'>
		{foreach name=Conditionsbucle from=$step->getAllConditionsText() key=order item=text}
			<option value="{$order}" {if $text == $condition->getText()}selected{/if}>{l s="$text" mod="massivo"}</option>
		{/foreach}
	</select>
</td>	