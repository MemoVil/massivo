<div class="panel-body">
	<div class="panel-heading">	
			{l s="Recipe editor"}
		<span class="badge recipeid">
			{$recipe->id}
		</span>
		<span class="panel-heading-action">
			<a class="list-toolbar-btn addStep">
				<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s="Add a step to this recipe" mod="Massivo"}" data-html="true" data-placement="top">	
					<i class="process-icon-new ">
					</i>
				</span>
			</a>
			<a class="list-toolbar-btn deleteStep">
				<span title="" data-toggle="tooltip" class="label-tooltip" data-original-title="{l s="Deletes this step from the recipe" mod="Massivo"}" data-html="true" data-placement="top">					
					<i class="icon-trash list-toolbar-btn">
			  		</i>
		  		</span>
	  		</a>
		</span>
	</div>	 
	<form class="form-horizontal stepsform">
		<div class="table-responsive-row clearfix">
			<table id="steplist" class="table table-striped table-highlight text-info table product">
	  			<thead>  
		  			<tr class="nodrag nodrop">					
		  				<th class="fixed-width-xs center">
		  				</th>
		  				<th class="fixed-width-xs center">
		  					<span class="title_box active">
		  						{l s="Step" mod="massivo"}
		  					</span>
		  				</th>
		  				<th class="center">
		  					<span class="title_box active">
		  						{l s="Name" mod="massivo"}
		  					</span>
		  				</th>
		  				<th class="center">
		  					<span class="title_box active">
		  						{l s="Conditions and Actions" mod="massivo"}
		  					</span>
		  				</th>
		  			</tr>	  				
	  			</thead>
	  			 {foreach name=buclecard from=$steps key=pos item=step}
	  			 <tr class='bucle'>
	  			 	<td>
	  			 		<input type="checkbox" class="checkStep"></input>
	  			 	</td>
		  			 <td class="text-center">
						{$pos + 1}
		  			 </td>
		  			 <td class="text-center">
		  			 	{$step->name}
		  			 </td>		  
		  			 <td>
		  			 	<table class="table  table-condensed table-highlight table-hover text-info table product" small>
		  			 		<thead>  
		  			 			<tr class="success">
				  			 		<th class="text-center">
				  			 			{l s="Conditions" mod="massivo"}
				  			 		</th>
				  			 		<th>
				  			 		</th>
			  			 		</tr>
		  			 		</thead>
		  			 		{if $step->conditions|is_array && $step->conditions|@count > 0}
		  			 		{foreach name=conditionbucle from=$step->conditions key=cpos item=stepcondition}
		  			 			<tr>
					  			 	<td>
					  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" conditionstep="{$cpos}">
											{$stepcondition->getFullDescription()}
					  			 		</p>
					  			 	</td>
					  			 	<td>		  			 		        
								        <button type="button" class="btn btn-error deletestepaction" recipe="{$recipe->id}" step="{$step->id}" conditionstep="{$cpos}">
								            {l s="Delete" mod="massivo"}
								        </button>
			    					</td>
		    					</tr>
		  			 		{/foreach}
		  			 		{else}
		  			 			<tr >
			  			 			<td class="text-center">
			  			 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" conditionstep="{$cpos}">
			  			 					<em>
			  			 						{l s="There are no conditions for this step at this time, press here to create a new one" mod="massivo"}
			  			 					</em>
			  			 				</p>
			  			 			</td>
			  			 			<td>
			  			 			</td>
		  			 			</tr>
		  			 		{/if}
		  			 	 </table>
		  			 	 <table class="table table-condensed table-highlight table-hover text-info table product small">
		  			 		<thead>  
		  			 			<tr class="warning">
				  			 		<th class="text-center">
				  			 			{l s="Actions" mod="massivo"}
				  			 		</th>
				  			 		<th>
				  			 		</th>
			  			 		</tr>
		  			 		</thead>
		  			 		{if $step->actions|is_array && $step->actions|@count > 0}
		  			 		{foreach name=actionsbucle from=$step->actions key=cpos item=stepaction}
		  			 			<tr>
					  			 	<td>
					  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" actionstep="{$cpos}">
											{$stepaction->getFullDescription()}
					  			 		</p>
					  			 	</td>
					  			 	<td>		  			 		        
								        <button type="button" class="btn btn-error deletestepaction" recipe="{$recipe->id}" step="{$step->id}" actionstep="{$cpos}">
								            {l s="Delete" mod="massivo"}
								        </button>
			    					</td>
		    					</tr>
		  			 		{/foreach}
		  			 		{else}
		  			 			<tr>
			  			 			<td class="text-center">
			  			 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" actionstep="{$cpos}">
			  			 					<em>
			  			 						{l s="There are no actions for this step at this time, press here to create a new one" mod="massivo"}
			  			 					</em>
			  			 				</p>
			  			 			</td>
			  			 			<td>
			  			 			</td>
		  			 			</tr>
		  			 		{/if}
		  			 	 </table>
		  			 </td>			 
	  			 </tr>
	  			 {/foreach}
			</table>
		</div>
	</form>
</div>

<div id="addNewStep" class="hidden col-xs-12">
    <div class="input-group fancyAdd col-xs-12">
      <input type="text" class="form-control col-xs-10 inputaddfancystep" placeholder="{l s="Type here name for new Step" mod="massivo"}...">
      <span class="input-group-btn col-xs-2">
        <button class="btn btn-default addfancystep" type="button">{l s="Add Step" mod="massivo"}</button>
      </span>
    </div>
</div>
{literal}
	<script type="text/javascript" id="runCreateTabStepsForm">
		function doAjaxForMe(vStep)		
		{	
			var ajaxStep = vStep;
			var recipeId = {/literal}{$recipe->id}{literal};
			var t = $.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: { ajax: "true", operation: "addBlankStep", step: ajaxStep, massivo_key:{/literal}"{$massivo_key}",{literal} recipeid: {/literal}"{$recipe->id}"{literal}  } ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {
	              	var t = response.split("$");
	              	if (t[0] == "Error")
	              		showError(t[1]);
	              	else {	              		
	              		showSuccess(t[1]);	
	              		var rows = $('tr.bucle').length;
	              		rows = rows + 1;
	              		$html = '<tr class="bucle"><td class="text-center"><input type="checkbox" class="checkStep"></td>';
	              		$html = $html + ' <td class="text-center">' + rows + '</td><td class="text-center">' + t[2] + '</td>';
	              		$html = $html + '<td><table class="table table-condensed table-highlight table-hover text-info table product small"><thead> <tr class="success"><th class="text-center">{/literal}{l s="Conditions" mod="massivo"}{literal}</th><th></th></tr></thead>';
	              		$html = $html + '<tbody><tr><td class="text-center">{/literal}<p class="editable" recipe="' + recipeId +'" step="' + t[3] +'" conditionstep="1"><em>{l s="There are no conditions for this step at this time, press here to create a new one" mod="massivo"}</em></p> {literal}</td></tr></tbody></table>';
	              		console.log($html);
	              		$html = $html + '<table class="table table-condensed table-highlight table-hover text-info table product small"><thead> <tr class="warning"><th class="text-center">{/literal}{l s="Actions" mod="massivo"}{literal}</th><th></th></tr></thead>';
	              		$html = $html + '<tbody><tr><td class="text-center">{/literal}<p class="editable" recipe="' + recipeId +'" step="' + t[3] +'" actionstep="1"><em>{l s="There are no actions for this step at this time, press here to create a new one" mod="massivo"}</em></p> {literal}</td></tr></tbody></table></td></tr>';
	              		console.log($html);
	              		if ( $('#steplist tr.bucle') ) {
	              			$('#steplist tr.bucle').last().after($html);
	              		}
	              		else {
	              			$('#steplist tr:last').after($html);	              		
	              		}
	              		//$('#steplist tr:last').after($html);	              		
	              	}
          		  }		          
	        }); 
		}
    	$("a.addStep").click(
	    		function(){
		    		$html = $("#addNewStep").html();		    		    		
		    		$.fancybox(
		    			$html,
		    			{
		    				'autoSize': false,
		    				'width': 380,
		    				'minHeight': 30,
		    				'height': 30,
		    				'titlePosition': 'inside',
		    				'title':{/literal}"{l s="Add a new Step to this recipe" mod="massivo"}"{literal},
		    				'afterShow': function() {	
		    					$(".fancybox-opened").ready(function(){		    						
			    					$(".addfancystep").click(	
						    			function() {			
						    			 	event.preventDefault();								    				 
							    			if ( $('.fancybox-opened input').attr('value').length > 0 ) {
							    				doAjaxForMe($('.fancybox-opened input').attr('value'));
							    				$.fancybox.close();							    			 	
						    			 	}
						    			}
						    		);
			    				});			    				
	    			}   		
    		});
    	})
    	$("a.deleteStep").click(
    		function() {
    			var $checks = $('input[class=checkStep]:checked');
    			console.log($checks);
    	});
    	$("table p.editable").click(
    		function(){
    			var recipeid = $(this).attr('recipe');
    			var stepid = $(this).attr('step');
    			if ($(this).attr('stepaction'))
    			{
    				var stepaction = $(this).attr('stepaction');
    				var a = {operation: "displayActionSelector", recipe: recipeid, step:stepid, action: stepaction};
    			}
    			if ($(this).attr('stepcondition'))
    			{
    				var stepcondition = $(this).attr('stepcondition');
    				var a = {operation: "displayConditionSelector", recipe: recipeid, step:stepid, condition: stepcondition};
    			}
    			
    			$(this).load(
    				{/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
    				a
    			);
    		}
    	);
	</script>

{/literal}
