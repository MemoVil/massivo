{literal}
<script type="text/javascript">
$(document).ready(function() {
		/** Header tabs */
		$("li[class$='Tab']").click(			
			function()
			{ 
				$class = $(this).attr('class');
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
				
				/**
				$.ajax({
					url:"{/literal}{$module_dir}{literal}/massivo/classes/ajax/ajaxController.php",
					method:"POST",
					data: {operation:"tab",tab:$class},
					dataType: "json",
					context:document.body,
					error: function(xhr,status,error) {               
		              },
		            success: function (response) {     
		             
		             }
				});**/			
			}
		);
		/** Apply formula */
		/** Create formula */
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
		              url: "{/literal}{$module_dir}{literal}/massivo/classes/ajax/ajaxController.php",
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
		              url: "{/literal}{$module_dir}{literal}/massivo/classes/ajax/ajaxController.php",
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
