<td colspan="5">
		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" param="{$cpos}">
			{$condition->getFullDescription()}										
		</p>
</td>						  			 	  			 		        
<td>
	<button type="button" class="btn btn-success editcondition" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepcondition" param="{$cpos}">
	    <i class="icon-edit">  </i>
	</button>				    					
	<button type="button" class="btn btn-danger deletestepcondition" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepcondition" param="{$cpos}">
	    <i class="icon-trash">  </i>
	</button>				    					
</td>
<script type="text/javascript" class="triggerConditionButtons" {/literal}recipe="{$recipe->id}" step="{$step->id}" condition="{$row}"{literal}>

</script>
