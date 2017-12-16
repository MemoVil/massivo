<td recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		{foreach name=Conditionsbucle from=$step->getAllConditionsText() key=order item=text}
			<option value="{$row}" {if $text == $condition->getText()}selected{/if}>{l s="$text" mod="massivo"}</option>
		{/foreach}
	</select>
</td>	