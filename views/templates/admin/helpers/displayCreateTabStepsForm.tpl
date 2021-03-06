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
		  				<th class="center">
		  				</th>
		  				<th class="center">
		  					<span class="title_box active">
		  						{l s="Step" mod="massivo"}
		  					</span>
		  				</th>
		  				<th class="center ">
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
	  			 <tr class='bucle' order="{$pos+1}">
	  			 	<td class="rescaleTd">
	  			 		<input type="checkbox" class="checkStep" order="{$pos+1}"></input>
	  			 	</td>
		  			 <td class="text-center rescaleTd">
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
		  			 		{if $step->conditions|is_array && $step->conditions|@count > 0}
			  			 		{foreach name=conditionbucle from=$step->conditions key=cpos item=stepcondition}
			  			 			<tr class="stepcondition stepcondition-{$recipe->id}-{$step->id}" type="stepcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$cpos}" cid="{$stepcondition->getId()}">
						  			 	<td colspan="5">
						  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepcondition" row="{$cpos}" cid="{$stepcondition->getId()}">
												{$stepcondition->getFullDescription()}								
						  			 		</p>
						  			 	</td>	
						  			 	<td>					  			 			 		        
											<button type="button" class="btn btn-success editstepcondition" recipe="{$recipe->id}" step="{$step->id}"  type="editstepcondition" row="{$cpos}" cid="{$stepcondition->getId()}">
											    <i class="icon-edit">  </i>
											</button>				    					
											<button type="button" class="btn btn-danger deletestepcondition" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepcondition" row="{$cpos}" cid="{$stepcondition->getId()}">
											    <i class="icon-trash">  </i>
											</button>	    					
								    	</td>
			    					</tr>
			  			 		{/foreach}
		  			 		{/if}
			  			 			<tr class="newcondition" type="newcondition" recipe="{$recipe->id}" step="{$step->id}"  row="{$step->conditions|@count}">
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
		  			 		{if $step->actions|is_array && $step->actions|@count > 0}
			  			 		{foreach name=actionbucle from=$step->actions key=cpos item=stepaction}
			  			 			<tr class="stepaction" type="stepaction" recipe="{$recipe->id}" step="{$step->id}" row="{$cpos}" cid="{$stepaction->getId()}">
						  			 	<td colspan="5">
						  			 		<p class="editable" recipe="{$recipe->id}" step="{$step->id}" type="stepaction" row="{$cpos}" cid="{$stepaction->getId()}">
												{$stepaction->getFullDescription()}										
						  			 		</p>
						  			 	</td>	
						  			 	<td>					  			 			 		        
											<button type="button" class="btn btn-success editstepaction" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepaction" row="{$cpos}" cid="{$stepaction->getId()}">
											    <i class="icon-edit">  </i>
											</button>				    					
											<button type="button" class="btn btn-danger deletestepaction" recipe="{$recipe->id}" step="{$step->id}"  type="deletestepaction" row="{$cpos}" cid="{$stepaction->getId()}">
											    <i class="icon-trash">  </i>
											</button>	    					
								    	</td>
			    					</tr>
			  			 		{/foreach}		  	
			  			 	{/if}
		  			 			<tr class="newaction" type="newaction" recipe="{$recipe->id}" step="{$step->id}"  row="{$step->actions|@count}">
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
<table id="#ajaxtrash" class="hidden">
</table>
{literal}
	<script type="text/javascript" id="runCreateTabStepsForm">
		var recipeId = {/literal}{$recipe->id}{literal};
		var clickControl = 0;
		var massivo = "{/literal}{$massivo_key}{literal}";
		function showError(error) {
			var divError = '<div class="ajaxError alert alert-warning "><button type="button" class="close" data-dismiss="alert">×</button>'+error+'</div>';			
			$('.toppanel').before(divError);
			$('.ajaxError').delay(5000).fadeOut();
		}
		function showSuccess(message) {
			var divSuccess = '<div class="ajaxSuccess alert alert-success "><button type="button" class="close" data-dismiss="alert">×</button>' + message + '</div>';			
			$('.toppanel').before(divSuccess);
			$('.ajaxSuccess').delay(5000).fadeOut();
		}
		function runRemoteScript(remote)
		{
			eval(remote.text());
		}
		function setObjectData(recipe,step,row)
		{
			atad = {}; jatad = {};
			atad.recipe = recipe; atad.step = step; atad.row = row;
			jatad.recipe = recipe; jatad.step = step; jatad.row = row;
			atad.massivo_key = "{/literal}{$massivo_key}{literal}";
			jatad.massivo_key = "{/literal}{$massivo_key}{literal}";
			jatad.operation = 'getScript';
		}
		function expandDefault(options,getscript)
		{
			if (options.operation == 'displayConditionCreateMode')
				expandDefaultCondition(options,getscript);
			else
				expandDefaultAction(options,getscript);
		}

		function expandDefaultCondition(options,getscript)
		{
			    $.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: options,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {	     
	              	var tr = $('tr[type="newcondition"][recipe=' + options.recipe + '][step=' + options.step + '][row=' + options.row + ']');
	              	tr.replaceWith(response);		              	
           			var r = $.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			getscript,
              			null,
              			'script'
          			);	    
          			r.fail(
          				function(o,text,error) {
          					console.log(error);
          					console.log(text);
          				}
          			);          	       
	              }
	          	});
		}
		function expandDefaultAction(options,getscript)
		{

			   $.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: options ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {	    
    				var t = response.split("$");
	              	if (t[0] == "Error") {
	              		showError(t[1]);
	              		return;
	              	}

	              	var tr = $('tr[type="newaction"][recipe=' + options.recipe + '][step=' + options.step + '][row=' + options.row + ']');
	              	tr.replaceWith(response);		   	              	
           			var r = $.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			getscript,
              			null,
              			'script'
          			);	              			
          			r.fail(
          				function(o,text,error) {
          					console.log(error);
          					console.log(text);
          				}
          			);      
          			//If default action is showed we must load its content via new ajax calls, including scripts
          			var tr = $('tr[type="stepaction"][recipe=' + options.recipe + '][step=' + options.step + '][row=' +options.row + ']');           	
	              	var td = tr.find('.inputSelectAction');
	              	var sel = td.find("option:selected").attr('value');		              		              	
	              	options.time = 'actionDescription';
	              	options.type = sel;
	              	var r = $.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			options,
              			function(data,status,xhr){
		              		tr.find('.actionDescription').replaceWith(data);
              				getscript.time='actionDescription';
              				$.get(
              					"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              					getscript,
              					function(data,status){
              						options.time = 'actionParam';
              						$.get(
              							"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              							options,
              							function(data,status){
              								tr.find('.actionParam').replaceWith(data);
              								getscript.time = 'actionParam';
              								$.get(
              									"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              									getscript,
              									null,
              									'script'
              								);              								
              							}
              						);
              					},
              					'script'
              				);
              			});
	           	   }
	          	});

		}
		function attachEditableFunctionToStepList(el)
		{				
				var id = el.attr('recipe');
    			var stepid = el.attr('step'); 
    			var massivokey = {/literal}"{$massivo_key}"{literal};
    			var perform = el.attr('type');
    			var cpos = el.attr('row');
    			var cid = el.attr('cid');
    			var aid = el.attr('aid');
    			var atad = { recipe: id, step:stepid, massivo_key: massivokey, action: perform};       			
    			if ( cpos )
    				atad.row= cpos; 	
    			
    			var jatad = { recipe: id, step:stepid, massivo_key: massivokey};   
    			if (aid){
    				atad.aid = aid;
    				jatad.aid = aid;
    			}
    			switch (perform)
    			{
    				case 'newcondition':
    					atad.operation = "displayConditionCreateMode";
    					atad.time = 'start';
    					break;
    				case 'newaction':
    					atad.operation = "displayActionCreateMode";
    					atad.time = 'start';
    					break;    
    				default:
    					return;					
    				break;
    			}
    			jatad.operation = 'getScript';
    			jatad.script = atad.operation;
    			jatad.row = atad.row;
    			expandDefault(atad,jatad);
		}
		function doEval(response)
		{
			$('#ajaxtrash').html(response);
			//Little trick to avoid injection: massivo key hidden key
			$('#ajaxtrash').find('script[key="{/literal}{$massivo_key}{literal}"]').each(
				function() {
					eval($(this).text());
				}
			);
		}
		function doAjaxForMe(vStep)		
		{	
			var ajaxStep = vStep;
			
			var t = $.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: { ajax: "true", operation: "addBlankStep", step: ajaxStep, massivo_key:{/literal}"{$massivo_key}",{literal} recipe: {/literal}"{$recipe->id}"{literal}  } ,
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
	              		$html = t[3];
	              		
	              		if ( $('tr.bucle').length ) {
	              			$('tr.bucle').last().after($html);	              			
	              		}
	              		else {
	              			$('#steplist').append($html);	              		
	              		}
	              		$("table p.editable").unbind("click");
	              		$("table p.editable").click(
	              			function(event)
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
		              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
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
  	 	$('button.editstepcondition').click(
			function()
			{
				var rId = $(this).attr('recipe'); var sId = $(this).attr('step'); var rowId = $(this).attr('row'); var cId = $(this).attr('cid');
				var b = $(this);
				$.ajax({
		              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: {massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, cid: cId, operation: 'editStepCondition'} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	console.log(xhr);
		              },
		              success:  function (response) {	              	
		              	var tr =b.parent().parent();
		              	tr.html(response);
		              	var r = $.get(
		              		"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              		{massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, cid: cId, script: 'displayConditionEditButtons', operation: 'getScript'} ,
		              		null,
		              		'script'
		              	);
		              	jatad.operation = 'getScript';
						jatad.script = 'displayConditionCreateMode';         					
           				$.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			{massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, cid: cId, script: 'displayConditionCreateMode', operation: 'getScript'} ,
              			null,
              			'script'
          			);	
		        	 }
		      	});
			}
		);
		$('button.deletestepcondition').click(
		function() {
			var rId = $(this).attr('recipe'); var sId = $(this).attr('step'); var rowId = $(this).attr('row'); var cId = $(this).attr('cid');
			var b = $(this);			
			$.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	           	  data: {massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, cid: cId, operation: 'deleteStepCondition'} ,
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
		            		$('tr.stepcondition[recipe="'+rId+'"][step="'+sId+'"][row="'+ rowId+'"][cid="' + cId + '"').remove();  		
		              	}              		
	              }
          	});

		}
	);
 	 	$('button.editstepaction').click(
			function()
			{
				var rId = $(this).attr('recipe'); var sId = $(this).attr('step'); var rowId = $(this).attr('row'); var aId = $(this).attr('aid');
				var b = $(this);
				$.ajax({
		              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: {massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, aid: aId, operation: 'editStepAction'} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	console.log(xhr);
		              },
		              success:  function (response) {	              	
		              	var tr =b.parent().parent();
		              	tr.html(response);
		              	var r = $.get(
		              		"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
		              		{massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, aid: aId, script: 'displayActionEditButtons', operation: 'getScript'} ,
		              		null,
		              		'script'
		              	);
		              	jatad.operation = 'getScript';
						jatad.script = 'displayActionCreateMode';         					
           				$.get(
              			"{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
              			{massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, aid: aId, script: 'displayActionCreateMode', operation: 'getScript'} ,
              			null,
              			'script'
          			);	
		        	 }
		      	});
			}
		);
		$('button.deletestepaction').click(
		function() {
			var rId = $(this).attr('recipe'); var sId = $(this).attr('step'); var rowId = $(this).attr('row'); var aId = $(this).attr('aid');
			var b = $(this);			
			$.ajax({
	              url: "{/literal}{$module_dir}{literal}massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	           	  data: {massivo_key: {/literal}"{$massivo_key}"{literal}, row: rowId, recipe: rId, step: sId, aid: aId, operation: 'deleteStepAction'} ,
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
		            		$('tr.stepaction[recipe="'+rId+'"][step="'+sId+'"][row="'+ rowId+'"][aid="' + aId + '"').remove();  		
		              	}              		
	              }
          	});

		}
	);
	</script>

{/literal}
