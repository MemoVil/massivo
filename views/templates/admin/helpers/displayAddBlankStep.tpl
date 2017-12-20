<tr class='bucle' order="{$pos+1}">
 	<td>
 		<input type="checkbox" class="checkStep" order="{$pos+1}"></input>
 	</td>
	 <td class="text-center">
	{$pos + 1}
	 </td>
	 <td class="text-center rescaleTd">
	 	{$step->name}
	 </td>		  
	 <td>
	 	{assign "tableproperties" "fulltr table table-highlight table-hover text-info  table-responsive"}
	 	<table class="{$tableproperties}">
	 		<thead>  
	 			<tr class="bg-primary white-border">
			 		<th colspan="6" class="text-center">
			 			{l s="Conditions" mod="massivo"}
			 		</th>				  			 		
		 		</tr>
	 		</thead>	 		
 			<tr type="newcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$step->conditions|@count}">
	 			<td colspan="6" class="text-center subtablenewcondition">
	 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="newcondition" row="{$step->conditions|@count}" >
	 					<em>
	 						{l s="Press here to add a new condition" mod="massivo"}
	 					</em>
	 				</p>
	 			</td>			  			 
 			</tr>		  			 		
	 	 </table>
	 	 <table class="{$tableproperties}">
	 		<thead>  
	 			<tr class="bg-white black-border">
			 		<th colspan="6" class="text-center text-black">
			 			{l s="Actions" mod="massivo"}
			 		</th>				  			 		
		 		</tr>
	 		</thead>	 		
 			<tr type="newaction" recipe="{$recipe->id}" step="{$step->id}"  row="{$step->actions|@count}">
	 			<td colspan="6" class="text-center subtablenewaction">
	 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="newaction" row="{$step->actions|@count}">
	 					<em>
	 						{l s="Press here to create a new action" mod="massivo"}
	 					</em>
	 				</p>
	 			</td>
 			</tr>		  			 		
	 	 </table>
	 </td>			 
 </tr>