<tr class="stepaction" type="stepaction" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" aid="{$aid}">
	<td>
		<select class="inputSelectAction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			{foreach name=cbucle from=$step->getAllActionsText() key=cpos item=text}
				<option value="{$cpos}">{l s="$text" mod="massivo"}</option>
			{/foreach}
		</select>
	</td>		
	<td class="leftLongActionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="inputSelectActionVerb" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="rightLongActionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="inputParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="actionButton" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
		<button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			<i class="icon-trash"></i>
		</button>
	</td>		
</tr>
