{if $time == 'start'}
<tr class="stepaction" type="stepaction" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" aid="{$aid}">
	<td class="start">
		<select class="inputSelectAction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			{foreach name=cbucle from=$step->getAllActionsText() key=cpos item=text}
				<option value="{$cpos}">{l s="$text" mod="massivo"}</option>
			{/foreach}
		</select>
		<input class="aidValue hidden" value="{$aid}">
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
{/if}
{if $time == 'actionDescription'}
<td class="actionDescription" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
		<select class="inputSelectProductDetail" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
			<option value="%product%" selected>{l s="Product ID" mod="massivo"}</option>
			<option value="%combination%">{l s="Product combination ID" mod="massivo"}</option>
			<option value="%productname%">{l s="Product name" mod="massivo"}</option>
			<option value="%feature%">{l s="Product feature value" mod="massivo"}</option>			
		</select>
</td>
{/if}
{if $time == 'actionParam'}
<td class="actionParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	{if $value !== "%feature%"}
		<input class="hidden" value="{$value}">	
	{else}
		<select class="inputSelectFeature" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
		   <option selected disabled hidden value="waiting">{l s="Please select feature group" mod="massivo"}</option>
		   {foreach name=fbucle from=$features key=cpos item=feature}
				<option value="{$cpos}">{l s="$feature" mod="massivo"}</option>
    		{/foreach}
		</select>
	{/if}
</td>
{/if}
{if $time == 'actionEditButtons'}
<td  class="actionEditButtons" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
	<button type="button" class="btn btn-danger canceleditaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" aid="{$aid}">
		<i class="icon-trash"></i>
	</button>
	<button type="button" class="btn btn-success saveeditaction" recipe="{$recipe->id}" step="{$step->id}" row="{$row}"  aid="{$aid}">
	    <i class="icon-check"></i>
	</button>     
</td>
{/if}
