{literal}
<script type="text/javascript">
$(document).ready(function() {
	
		/** Header tabs */
		$("li[class$='Tab'] ").each(
			function(i,val) {
				$class = $(this).attr('class').replace('hidden','').replace('active ',''); 					
				if ( !$(this).hasClass('active') )
				{					
					$temp_class = $(this).attr('class'); 					
					$('#' + $temp_class).addClass('hidden');
				}
				else
				{					
					$('#' + $class).removeClass('hidden');
				}
			}
		);
		$("li[class$='Tab']").click(			
			function()
			{ 
				$class = $(this).attr('class');				
				if ( $(this).hasClass('active'))
				 	return true;																		
				$("ul.massivo_header > li").each(
					function(i,val) {							
						$(this).removeClass('active');
						$temp_class = $(this).attr('class'); 							
						if ($class != $temp_class)
						{
							$('#' + $temp_class).removeClass('hidden');
							$('#' + $temp_class).addClass('hidden');
						}
						else 
						{
							$(this).addClass('active');
						}						
					}
				);								
				$('#' + $class).removeClass('hidden');			
			}
		);
		/** Apply formula */
		/** Create formula */
		$(".linav").click(
				function(){
					$class = $(this).attr('class').replace('active','').replace('linav','').trim();
					console.log($class);
					switch ($class)
					{
						case 'l1':
							$(".l1").addClass('active');
							$(".l2").removeClass('active');
							$(".l3").removeClass('active');							
							$(".unav1").removeClass('hidden');
							$(".unav2").addClass('hidden');
							$(".unav3").addClass('hidden');
							break;
						case 'l2':							
							$(".l1").removeClass('active');
							$(".l2").addClass('active');
							$(".l3").removeClass('active');
							$(".unav1").addClass('hidden');
							$(".unav2").removeClass('hidden');
							$(".unav3").addClass('hidden');
							break;
						case 'l3':
							$(".l1").removeClass('active');
							$(".l2").removeClass('active');
							$(".l3").addClass('active');
							$(".unav1").addClass('hidden');
							$(".unav2").addClass('hidden');
							$(".unav3").removeClass('hidden');
							break;
					}
				}
		);
		function showError(error) {
			var divError = '<div class="ajaxError alert alert-warning ">' + error + '<button type="button" class="close" data-dismiss="alert">×</button></div>';			
			$('.toppanel').before(divError);
		}
		function showSuccess(message) {
			var divSuccess = '<div class="ajaxSuccess alert alert-success ">' + message + '<button type="button" class="close" data-dismiss="alert">×</button></div>';			
			$('.toppanel').before(divSuccess);
		}
		/* Begin editable rows */
		function getStyle(el, cssprop) {
			if (el.currentStyle)
				return el.currentStyle[cssprop];	 // IE
			else if (document.defaultView && document.defaultView.getComputedStyle)
				return document.defaultView.getComputedStyle(el, "")[cssprop];	// Firefox
			else
				return el.style[cssprop]; //try and get inline style
		}

		function applyEdit(tabID, editables) {
			var tab = document.getElementById(tabID);
			if (tab) {
				var rows = tab.getElementsByTagName("tr");
				for(var r = 0; r < rows.length; r++) {
					var tds = rows[r].getElementsByTagName("td");
					for (var c = 0; c < tds.length; c++) {
						if (editables.indexOf(c) > -1)
							tds[c].onclick = function () { beginEdit(this); };
					}
				}
			}
		}
		var oldColor, oldText, padTop, padBottom = "";
		function beginEdit(td) {

			if (td.firstChild && td.firstChild.tagName == "INPUT")
				return;

			oldText = td.innerHTML.trim();
			if  ( $(td).hasClass('even') )
				oldColor = "#fff";
			else
				oldColor = "#f9f9f9";
			

			padTop = getStyle(td, "paddingTop");
			padBottom = getStyle(td, "paddingBottom");

			var input = document.createElement("input");
			input.value = oldText;

			//// ------- input style -------
			var left = getStyle(td, "paddingLeft").replace("px", "");
			var right = getStyle(td, "paddingRight").replace("px", "");
			input.style.width = '100%'//td.offsetWidth - left - right - (td.clientLeft * 2) - 2 + "px";
			input.style.height = td.offsetHeight - (td.clientTop * 2) - 2 + "px";
			input.style.border = "0px";
			input.style.fontFamily = "inherit";
			input.style.fontSize = "inherit";
			input.style.textAlign = "inherit";
			input.style.backgroundColor = "white";

			input.onblur = function () { endEdit(this); };
			$(input).keyup(function(e){
				if (e.which !== 13) {
   				    return;
  				}
  				endEdit(input);
			});

			td.innerHTML = "";
			td.style.paddingTop = "0px";
			td.style.paddingBottom = "0px";
			td.style.backgroundColor = "LightGoldenRodYellow";
			td.insertBefore(input, td.firstChild);
			input.select();
		}
		function endEdit(input) {
			var td = input.parentNode;
			td.removeChild(td.firstChild);	//remove input
			td.innerHTML = input.value;
			if (oldText != input.value.trim() )
				td.style.color = "red";

			td.style.paddingTop = padTop;
			td.style.paddingBottom = padBottom;
			td.style.backgroundColor = oldColor;
			if (oldText != input.value.trim() ) {
				$.ajax({
		              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: { ajax: "true", operation: "renameRecipe", massivo_key:{/literal}"{$massivo_key}"{literal},param: input.value, recipeid: $(td).parent().attr('recipeid')} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	
		              },
		              success:  function (response) {
		              	var t = response.split("$");
		              	if (t[0] == "Error")
		              		showError(t[1]);
		              	else
		              		showSuccess(t[1]);
              		  }		          
		        }); 	
			}	

		}
		applyEdit("recipetable", [1]);
		
		/* End Editable rows */
		function loadSteps(recipe)
		{		$.ajax({
		              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: { ajax: "true", operation: "loadSteps", massivo_key:{/literal}"{$massivo_key}"{literal},param: recipe} ,
		              dataType: "html",
		              context: document.body,
		              error: function(xhr,status,error) {
		              	
		              },
		              success:  function (response) {
		              	$("#ajaxCreateTab").removeClass("hidden");
		              	$("#ajaxCreateTab").html(response);  
		              	$('[data-toggle="tooltip"]').tooltip(); 	
		              	$("#ajaxCreateTab").find("script").each(function(i) {		              			
                    			eval($(this).text());
                		});
              		  }		          
		        }); 	
		}
		function deleteRecipe(recipe)
   		{
			$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: { ajax: "true", operation: "deleteRecipe", massivo_key:{/literal}"{$massivo_key}"{literal},recipeid: recipe} ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	
	              },
	              success:  function (response) {
      	           	var t = response.split("$");
	              	if (t[0] == "Error")
	              		showError(t[1]);
	              	else {
	              		$('tr[recipeid="' + recipe +'"').remove();
	              		showSuccess(t[1]);	
	              		
	              	}
	      		  }		          
	        }); 
   		}	

		/* Click on Add Recipe button */
		function appendCard(response){   			
   			$('#recipelist tr:last').after(response);
   			/** We add again this item to click listener */
   			$("div.card, .editrecipe").click(
	   			function(){
	   				var recipe = $(this).attr('recipeid');
	   				loadSteps(recipe);
	   			}
   			);		
   			$(".deleterecipe").click(
	   			function(){
	   				var recipe = $(this).attr('recipeid');
	   				deleteRecipe(recipe);
	   			}
   			);
			applyEdit("recipetable", [1]);
   		}
   		function addRecipe(name)
   		{
				$.ajax({
	              url: {/literal}{$module_dir}{literal} + "massivo/classes/ajax/ajaxWorker.php",
	              method: "POST",
	              data: { ajax: "true", operation: "addRecipe", massivo_key:{/literal}"{$massivo_key}"{literal},param: name} ,
	              dataType: "html",
	              context: document.body,
	              error: function(xhr,status,error) {
	              	
	              },
	              success:  function (response) {
	              	appendCard(response);		              	   		              	                     
	      		  }		          
	        }); 
   		}
   		$(".addRecipeButton").click(
			function(){
				addRecipe($('.addRecipeText').val());
			}
   		);         

		$('.addRecipeText').keyup(function(e){
			if (e.which !== 13) {
				    return;
				}
				addRecipe($('.addRecipeText').val());
		});
   		/* Click on edit recipe button*/
   		$(".editrecipe").click(
   			function(){
   				var recipe = $(this).attr('recipeid');
   				loadSteps(recipe);
   			}
   		);
   	
   		/* Click on delete recipe button */
		$(".deleterecipe").click(
   			function(){
   				var recipe = $(this).attr('recipeid');
   				deleteRecipe(recipe);
   			}
   		);


		/** Edit tab inputs*/ 
		$("input.reference:text").change(
			function()
			{
				$comb = $(this).parent().parent().children(":first-child").html().trim();
				$val = $(this).val();
				/**console.log($comb); */
				if ($comb.length > 0 && $val.length > 0)
				{
			       $.ajax({
		              url: "{/literal}{$module_dir}{literal}/massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: { operation:"update", combination : $comb, val : $val, type :"reference", massivo_key:{/literal}"{$massivo_key}"{literal}} ,
		              dataType: "json",
		              context: document.body,
		              error: function(xhr,status,error) {               
		              },
		              success: function (response) {               
		                var retorno = response;
		                if ( retorno == 0 )
		                {
		                    
		                }                
		          
		              }
		            });
				}
			}
		);
			$("input.ean13:text").change(
			function()
			{
				$comb = $(this).parent().parent().children(":first-child").html().trim();
				$val = $(this).val();
				/**console.log($val);*/					
				if ($comb.length > 0 && $val.length > 0)
				{
			       $.ajax({
		              url: "{/literal}{$module_dir}{literal}/massivo/classes/ajax/ajaxWorker.php",
		              method: "POST",
		              data: { operation:"update", combination : $comb.trim(), val : $val, type : "ean13", massivo_key:{/literal}"{$massivo_key}"{literal}} ,
		              dataType: "json",
		              context: document.body,
		              error: function(xhr,status,error) {               
		              },
		              success: function (response) {               
		                var retorno = response;
		                if ( retorno == 0 )
		                {
		                    
		                }                
		          
		              }
		            });
				}
			}
		);
	});
 </script>  
 {/literal}              
