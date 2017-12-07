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
			<table class="table table-striped table-highlight table-hover text-info table product">
	  			<thead>  
		  			<tr class="nodrag nodrop">					
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
	  			 <tr>
		  			 <td>
						{$pos + 1}
		  			 </td>
		  			 <td>
		  			 	{$step->name}
		  			 </td>		  
		  			 <td>
		  			 	{foreach name=conditionbucle from=$step->conditions key=cpos item=stepcondition}
		  			 	<p>

		  			 	</p>
		  			 	{/foreach}
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
			$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxController.php",
	              method: "POST",
	              data: { ajax: "true", operation: "addBlankStep", massivo_key:{/literal}"{$massivo_key}"{literal}, step:vStep, recipeid: {/literal}"{$recipe->id}"{literal}  } ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	console.log(xhr);
	              },
	              success:  function (response) {
	              	if (response == 1)
	              	{
	              		$('.stepadded').removeClass('hidden');
	              	}	              	                     
	              	else	              		
	              		$('.stepadderror').removeClass('hidden');
          		  }		          
	        }) 
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
						    			 	}
						    			}
						    		);
			    				});			    				
	    			}   		
    		});
    	})
	</script>

{/literal}
