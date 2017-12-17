<tr class="stepcondition" type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">
	<td>
		<select class="inputSelectCondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			{foreach name=cbucle from=$step->getAllConditionsText() key=cpos item=text}
				<option value="{$cpos}">{l s="$text" mod="massivo"}</option>
			{/foreach}
		</select>
	</td>	
	<td class="leftLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="inputSelectConditionVerb" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="rightLongConditionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="inputParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
	</td>
	<td class="conditionButton" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		<button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			<i class="icon-trash"></i>
		</button>
	</td>		
</tr>
