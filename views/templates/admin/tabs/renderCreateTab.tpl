<div id="createTab" class="hidden createTab">
	<div class="row">
	  	<div class="col-xs-12">
	  		<div class="panel">	  						
	  			<div class="panel-body">	  			
	  				<div class="alert alert-info">{l s="Here you can create Recipes for your Store. A Recipe is a list of actions to perform over your catalog based on conditions that you can define" mod="massivo"}</div>
	  				<ul class="createTabSelector nav nav-pills nav-stacked col-xs-2">  						
  						<li role="presentation" class="active linav l1"><a href="#">{l s="Create a new Recipe" mod="massivo"}</a></li>
  						<li role="presentation" class="linav l2"><a href="#">{l s="Load existing Recipe" mod="massivo"}</a></li>
  					</ul>  					
				    <span class="unav1 col-xs-10 ">    					
				    	 <input type="text" class="col-xs-8 addRecipeText" placeholder="Add a new recipe by typing its name here..." aria-label="addRecipe">		
					      <span class="input-group-btn col-xs-2 ">
					        <button class="btn btn-danger addRecipeButton" type="button">Add recipe</button>
					      </span>			     
				    </span>
				    <ul class="unav2 nav nav-pills hidden col-xs-12">
  					{foreach name=external from=$recipes key=pos item=celda}
  						<li role="presentation" class="loadRecipe {$celda:id_script}">
  							<a href="#">{$celda.id_script}-{$celda:name}</a>
  						</li>    						  				
  					{/foreach}
					</ul>					
				</div>
				<hr />
				<div id="ajaxCreateTab">
				</div>
			</div>
	  	</div>
	</div>
</div>