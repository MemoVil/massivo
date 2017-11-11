{literal}
<script type="text/javascript">
$(document).ready(function() {
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
		              data: { combination : $comb, val : $val, type :"reference", massivo_key:{/literal}"{$massivo_key}"{literal}} ,
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
		              data: { combination : $comb.trim(), val : $val, type : "ean13", massivo_key:{/literal}"{$massivo_key}"{literal}} ,
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
