<td class="inputParam text-center" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
{assign var=getSelectable value=$condition->getSelectable()|@count} 
{if $getSelectable > 0}	
	<select class="inputSelectConditionParam" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		{foreach name=selectablebucle from=$condition->getSelectable() key=csel item=select}					
				<option value="{$select['id']}" 
					{if ( $condition->getParam()) && $select['id'] == $condition->getParam()|trim} 
						selected 
					{/if}
				>
					 {$select['public']}
				</option>
		{/foreach}
	</select>
{else}
	<input class="inputParam" type="text" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
		{if ($condition->getParam()) }
		 	{$condition->getParam()} 
		{/if}
	</input>
{/if}
