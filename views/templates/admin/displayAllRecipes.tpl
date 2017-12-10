 <table class="table table-striped table-highlight table-hover text-info table product">
 	<thead>
 		<th>{l s="Recipe" mod="massivo"}
 		</th>
 		<th>
 			{l s="Description" mod="massivo"}
 		</th>
 		<th>
 			{l s="Actions" mod="massivo"}
 		</th> 		
 	</thead> 	
 	 {foreach name=buclecard from=$recipes key=pos item=recipe}
        {include file="displayCard.tpl" text="{$recipe.name}" id={$recipe.id} pos={$pos} + 1} 
 	{/foreach}
 </table>
