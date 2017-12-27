<tr class="stepaction" type="stepaction" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" aid="{$aid}">
	<td>
		<select class="inputSelectAction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			{foreach name=cbucle from=$step->getAllActionsText() key=cpos item=text}
				<option value="{$cpos}" {if $cpos == $value} selected{/if}>{l s="$text" mod="massivo"}</option>
			{/foreach}
		</select>
		<input class="aidValue hidden" value="{$aid}" {if $value}type="{$value}"{/if}>
	</td>		
	<td class="actionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="actionParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	</td>
	<td class="actionButton" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
		<button type="button" class="btn btn-danger canceladdaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			<i class="icon-trash"></i>
		</button>
	</td>		
</tr>
</tr>
