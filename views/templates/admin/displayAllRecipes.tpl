 {foreach name=buclecard from=$recipes key=pos item=recipe}
        {include file="displayCard.tpl" text="{$recipe.name}" id={$recipe.id} pos={$pos} + 1}
 {/foreach}
