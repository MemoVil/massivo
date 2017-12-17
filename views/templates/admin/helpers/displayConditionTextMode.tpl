<tr class="stepcondition" type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}" colspan="5">
	 		<p class="editable text-center" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" row="{$row}">
				{$condition->getFullDescription()}										
	 		</p>
	 	</td>	
	 	<td recipe="{$recipe->id}" step="{$step->id}"  row="{$row}">				  			 			 		        
			<button type="button" class="btn btn-success editstepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			    <i class="icon-edit">  </i>
			</button>				    					
			<button type="button" class="btn btn-danger deletestepcondition" recipe="{$recipe->id}" step="{$step->id}" row="{$row}">
			    <i class="icon-trash">  </i>
			</button>	    					
		</td>
</tr>
