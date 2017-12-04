<div id="createTab" class="hidden createTab">
	<div class="row">
	  	<div class="col-xs-12">
	  		<div class="panel ">	  	  									
	  			<div class="panel-body">	  			
	  				<div class="alert alert-info">{l s="Here you can create Recipes for your Store. A Recipe is a list of actions to perform over your catalog based on conditions that you can define" mod="massivo"}</div>
	  				<ul class="createTabSelector nav nav-pills  col-xs-12 col-m-12">  						
  						<li role="presentation" class="active linav l1"><a href="#">{l s="Create a new Recipe" mod="massivo"}</a></li>
  						<li role="presentation" class="linav l2"><a href="#">{l s="Load existing Recipe" mod="massivo"}</a></li>  						
  						<li role="presentation" class="linav l3"><a href="#">{l s="Delete existing Recipe(s)" mod="massivo"}</a></li>
  					</ul>  					
				    <span class="unav1">    					
				    	 <input type="text" class="col-xs-10 addRecipeText" placeholder="Add a new recipe by typing its name here..." aria-label="addRecipe">		
					      <span class="input-group-btn col-xs-2 ">
					        <button class="btn btn-danger addRecipeButton" type="button">{l s="Add recipe" mod="massivo"}</button>
					      </span>			     
				    </span>
				    <ul class="unav2 nav nav-pills hidden col-xs-12">
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
				</div>
				<hr />
				<div id="ajaxCreateTab">
				</div>
			</div>
	  	</div>
	</div>
</div>