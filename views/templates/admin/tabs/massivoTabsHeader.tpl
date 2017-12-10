	
<div class="toppanel panel">
	<div>
		<ul class="nav nav-tabs massivo_header">			
			<li  class="{if $tab == 1}active {/if}createTab">				
				<a>					
					{l s="Create a recipe" mod="massivo"}
				</a>
			</li>
			<li  class="{if $tab == 2}active {/if}applyTab">				
				<a>{l s="Apply a recipe" mod="massivo"}</a>
			</li>
			<li  class="{if $tab == 3}active {/if}editTab">				
				<a>{l s="Edit combinations" mod="massivo"}</a>
			</li>
		</ul>
	</div>	

	

{* <div> closed on AdminMassivoController renderList return method*}