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
		<div class="clearfix">
			<table id="steplist" class="table table-striped table-highlight text-info table-responsive ">
	  			<thead>  
		  			<tr class="nodrag nodrop">					
		  				<th class="fixed-width-xs center col-xs-1">
		  				</th>
		  				<th class="fixed-width-xs center col-xs-1">
		  					<span class="title_box active">
		  						{l s="Step" mod="massivo"}
		  					</span>
		  				</th>
		  				<th class="center ">
		  					<span class="title_box active">
		  						{l s="Name" mod="massivo"}
		  					</span>
		  				</th>
		  				<th class="center col-md-8 ">
		  					<span class="title_box active">
		  						{l s="Conditions and Actions" mod="massivo"}
		  					</span>
		  				</th>
		  			</tr>	  				
	  			</thead>
	  			 {foreach name=buclecard from=$steps key=pos item=step}
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
				  			 		<th class="text-center">
				  			 			{l s="Conditions" mod="massivo"}
				  			 		</th>				  			 		
			  			 		</tr>
		  			 		</thead>
		  			 		{if $step->conditions|is_array && $step->conditions|@count > 0}
			  			 		{foreach name=conditionbucle from=$step->conditions key=cpos item=stepcondition}
			  			 			<tr type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  param="{$cpos}">
						  			 	<td>
						  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" param="{$cpos}">
												{$stepcondition->getFullDescription()}										
						  			 		</p>
						  			 	</td>						  			 	  			 		        
								        <button type="button" class="btn btn-error deletestepaction" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepcondition" param="{$cpos}">
								            <i class="icon-trash">  </i>
								        </button>				    					
			    					</tr>
			  			 		{/foreach}
		  			 		{/if}
		  			 			<tr type="newcondition" recipe="{$recipe->id}" step="{$step->id}"  param="{$step->conditions|@count}">
			  			 			<td class="text-center subtablenewcondition">
			  			 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="newcondition" param="{$step->conditions|@count}" >
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
				  			 		<th class="text-center text-black">
				  			 			{l s="Actions" mod="massivo"}
				  			 		</th>				  			 		
			  			 		</tr>
		  			 		</thead>
		  			 		{if $step->actions|is_array && $step->actions|@count > 0}
			  			 		{foreach name=actionsbucle from=$step->actions key=cpos item=stepaction}
			  			 			<tr type="stepaction"  recipe="{$recipe->id}" step="{$step->id}"  param="{$cpos}">
						  			 	<td>
						  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepaction" param="{$cpos}">
												{$stepaction->getFullDescription()}
						  			 		</p>
						  			 	</td>						  			 	
									     <button type="button" class="btn btn-error deletestepaction" recipe="{$recipe->id}" step="{$step->id}" type="deletestepaction" param="{$cpos}">
						            	    	<i class="icon-trash">  </i>
									     </button>				    					
			    					</tr>
			  			 		{/foreach}
		  			 		{/if}
		  			 			<tr type="newaction" recipe="{$recipe->id}" step="{$step->id}"  param="{$step->actions|@count}">
			  			 			<td class="text-center subtablenewaction">
			  			 				<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="newaction" param="{$step->actions|@count}">
			  			 					<em>
			  			 						{l s="Press here to create a new action" mod="massivo"}
			  			 					</em>
			  			 				</p>
			  			 			</td>
		  			 			</tr>		  			 		
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
		var recipeId = {/literal}{$recipe->id}{literal};
		function showError(error) {
			var divError = '<div class="ajaxError alert alert-warning ">' + error + '<button type="button" class="close" data-dismiss="alert">×</button></div>';			
			$('.toppanel').before(divError);
			$('.ajaxError').delay(5000).fadeOut();
		}
		function showSuccess(message) {
			var divSuccess = '<div class="ajaxSuccess alert alert-success ">' + message + '<button type="button" class="close" data-dismiss="alert">×</button></div>';			
			$('.toppanel').before(divSuccess);
			$('.ajaxSuccess').delay(5000).fadeOut();
		}
		function runRemoteScript(remote)
		{
			eval(remote.text());
		}
		function attachEditableFunctionToStepList(el)
		{
				var id = el.attr('recipe');
    			var stepid = el.attr('step'); 
    			var massivokey = {/literal}"{$massivo_key}"{literal};
    			var perform = el.attr('type');
    			if (el.attr('param')) var cpos = el.attr('param');
    			var atad = { recipeid: id, stepid:stepid, massivo_key: massivokey, action: perform};   
    			if ( cpos )
    				atad.param = cpos; 	
    			switch (perform)
    			{
    				case 'stepaction': 
    					atad.operation = "displayActionSelector";
    					atad.stepaction = perform;
    					break;
    				case 'stepcondition':
    				    atad.operation = "displayConditionSelector";
    					atad.stepcondition = perform;
    					break;				
    				case 'newcondition':
    					atad.operation = "displayNewConditionSelector";
    					break;
    				case 'newaction':
    					atad.operation = "displayNewActionSelector";
    					break;
    			}		
    			$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: atad ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {	              	
	              	$('tr[type=' + perform + '][step=' + stepid + '][param=' + cpos + ']').html(response);
	              	switch (perform)
	              	{
	              		case 'stepaction': case 'newaction': var runme = 'runActionSelector'; break;
	              		case 'stepcondition': case 'newcondition': var runme = 'runConditionSelector'; break;
	              	}
	              }
	          	});
    			
		}
		function doAjaxForMe(vStep)		
		{	
			var ajaxStep = vStep;
			
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
	              		$html = '<tr class="bucle" order="' + rows + '"><td order="' + rows + '"><input type="checkbox" class="checkStep" order="'+rows+'"></td>';
	              		$html = $html + ' <td class="text-center">' + rows + '</td><td class="text-center">' + t[2] + '</td>';
	              		$html = $html + '<td><table class="table table-condensed table-highlight table-hover text-info table product small"><thead> <tr class="success"><th class="text-center">{/literal}{l s="Conditions" mod="massivo"}{literal}</th><th></th></tr></thead>';
	              		$html = $html + '<tbody><tr><td class="text-center">{/literal}<p class="editable" recipe="' + recipeId +'" step="' + t[3] +'" conditionstep="1"><em>{l s="There are no conditions for this step at this time, press here to create a new one" mod="massivo"}</em></p> {literal}</td></tr></tbody></table>';	              		
	              		$html = $html + '<table class="table table-condensed table-highlight table-hover text-info table product small"><thead> <tr class="warning"><th class="text-center">{/literal}{l s="Actions" mod="massivo"}{literal}</th><th></th></tr></thead>';
	              		$html = $html + '<tbody><tr><td class="text-center">{/literal}<p class="editable" recipe="' + recipeId +'" step="' + t[3] +'" actionstep="1"><em>{l s="There are no actions for this step at this time, press here to create a new one" mod="massivo"}</em></p> {literal}</td></tr></tbody></table></td></tr>';
	              		
	              		if ( $('tr.bucle').length ) {
	              			$('tr.bucle').last().after($html);	              			
	              		}
	              		else {
	              			$('#steplist').append($html);	              		
	              		}
	              		$("table p.editable").unbind("click");
	              		$("table p.editable").click(
	              			function()
	              			{
	              				attachEditableFunctionToStepList($(this));	              				
	              			});
	              	}
          		  }		          
	        }); 
		}
		$("a.addStep").unbind("click");
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
    	$("a.deleteStep").unbind("click");
    	$("a.deleteStep").click(
    		function() {
    			var $checks = $('input[class=checkStep]:checked');  
    			var i = new Array();  			
    			$checks.each(
    				function(){
    					i.push($(this).attr('order'));
    				}
    			);
    			$.ajax({
		              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: { ajax: "true", operation: "deleteSteps", massivo_key:{/literal}"{$massivo_key}"{literal},param: i.join(' '), recipeid: recipeId} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {		              	
		              },
		              success:  function (response) {
		              	var t = response.split("$");
		             	if (t[0] == "Error")
	              			showError(t[1]);
		              	else {	              		
		              		showSuccess(t[1]);			              		
			             	$('tr.bucle').each(
			              		function() {
			              			var order = $(this).attr('order');	  	
			              			var t = jQuery.inArray(order,i);			              			
			              			if ( t >= 0 ){
			              				$(this).remove();
			              			}
			              		}
			              	);
		              	}
		              	
              		  }		          
		        }); 	    			
    	});
    	$("table p.editable").unbind("click");
    	$("table p.editable").click(
    		function(){
    			attachEditableFunctionToStepList($(this));
    		}   		
    	);
	</script>

{/literal}
