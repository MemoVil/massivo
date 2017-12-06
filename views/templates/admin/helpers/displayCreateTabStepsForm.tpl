<div class="panel-body">
	<div class="panel-heading">	
		{l s="Recipe editor"}
		<span class="badge">
		</span>
		<span class="panel-heading-action">
			<i class="process-icon-new">
			</i>
			<i class="icon-trash">
	  		</i>
		</span>
	</div>	 
	<form class="form-horizontal stepsform">
		<div class="table-responsive">
			<table class="table table-bordered table-striped table-highlight table-hover text-info">
	  			<thead>  				
	  				<th>{l s="Order" mod="massivo"}</th>
	  				<th>{l s="Step" mod="massivo"}</th>
	  				<th>{l s="Actions" mod="massivo"}</th>
	  				
	  			</thead>
	  			 {foreach name=buclecard from=$steps key=pos item=step}
	  			 <tr>
		  			 <td>
						{$pos}
		  			 </td>
		  			 <td>
		  			 	{$step->name}
		  			 </td>		  			 
	  			 </tr>
	  			 {/foreach}
			</table>
		</div>
	</form>
</div>


