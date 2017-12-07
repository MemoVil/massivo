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
				    {*<ul class="unav2 nav nav-pills hidden col-xs-12">
				    	<select class="selectpicker selectLoadRecipe" >
  					{foreach name=external from=$recipes key=pos item=celda}
  						<option role="presentation" class="loadRecipe {$celda.id}">
  							{$celda.name}
  						</option>    						  				
  					{/foreach}
  						</select>
					</ul>					
					<ul class="unav3 nav nav-pills hidden col-xs-12 col-m-12">
				    	<select class="selectpicker col-xs-10 selectDeleteRecipe" multiple>
  					{foreach name=external from=$recipes key=pos item=celda}
  						<option role="presentation" class="deleteRecipe {$celda.id}">
  							{$celda.name}
  						</option>    						  				
  					{/foreach}
  						</select>
  						 <span class="input-group-btn col-xs-2">
					        <button class="btn btn-danger addRecipeButton" type="button">{l s="Delete" mod="massivo"}</button>
					      </span>		
					</ul>	
					*}
					<div id="recipelist">						
					{foreach name=buclecard from=$recipes key=pos item=recipe}
						{include file="../displayCard.tpl" text="{$recipe.name}" id="{$recipe.id}" pos={$pos} + 1}
					{/foreach}
					</div>
					<hr />
				</div>	
			</div>
			<div class="alert alert-success hidden stepadded">
				{l s="Step was added successfully" mod="massivo"}
			</div>
			<div class="alert alert-warning hidden stepadderror">
				{l s="Step was not added" mod="massivo"}
			</div>
			<div id="ajaxCreateTab" class="panel">	  	  									
			</div>
	  	</div>
	</div>
</div>