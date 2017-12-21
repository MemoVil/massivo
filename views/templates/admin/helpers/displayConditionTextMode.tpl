<tr class="stepcondition" type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" cid="{$condition->getId()}">
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" colspan="5">
	 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" row="{$row}" cid="{$condition->getId()}">
				{$condition->getFullDescription()}										
	 		</p>
	 	</td>	
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" cid="{$condition->getId()}">				  			 			 		        
			<button type="button" class="btn btn-success editstepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" cid="{$condition->getId()}">
			    <i class="icon-edit">  </i>
			</button>				    					
			<button type="button" class="btn btn-danger deletestepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}" cid="{$condition->getId()}">
			    <i class="icon-trash">  </i>
			</button>	    					
		</td>
</tr>
