<div id="createTab" class="hidden createTab">
	<div class="row">
	  	<div class="col-xs-12">
	  		<div class="panel ">	  	  									
	  			<div class="panel-body">	  			
	  				<div class="alert alert-info">{l s="Here you can create Recipes for your Store. A Recipe is a list of actions to perform over your Store based on conditions that you can define" mod="massivo"}</div>					
				    <div class="unav1 col-xs-12">    					
				    	 <input type="text" class="col-xs-10 addRecipeText" placeholder="Add a new recipe by typing its name here..." aria-label="addRecipe">		
					      <span class="input-group-btn col-xs-2 ">
					        <button class="btn btn-danger addRecipeButton" type="button">{l s="Add recipe" mod="massivo"}</button>
					      </span>			     
					</div>
					<div id="recipelist">				
							<table id="recipetable" class="table table-striped table-highlight table-hover text-info table product">
		 					<thead>
		 						<th>
		 							{l s="Recipe" mod="massivo"}
		 						</th>
		 						<th>
		 							{l s="Description" mod="massivo"}
		 						</th>
		 						<th>
		 							{l s="Actions" mod="massivo"}
		 						</th> 		
		 					</thead> 		
					{foreach name=buclecard from=$recipes key=pos item=recipe}
						{include file="../displayCard.tpl" text="{$recipe.name}" id="{$recipe.id}" pos={$pos} + 1}
					{/foreach}
							</table>
					</div>
					<hr />
				</div>	
			</div>
	  	</div>
	</div>
	<div id='ajaxCreateTab' class='hidden panel'>
	</div>
</div>