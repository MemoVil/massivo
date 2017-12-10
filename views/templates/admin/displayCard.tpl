<tr class="amulet" recipeid="{$id}">
    <td>
        {$pos}
    </td>
    <td class="editable {if $pos is even} even{/if}">
        {$text}                        
    </td>

    <td>
        <button type="button" class="btn btn-success editrecipe" recipeid="{$id}">
            {l s="Edit" mod="massivo"}            
        </button>
        <button type="button" class="btn btn-error deleterecipe" recipeid="{$id}">
            {l s="Delete" mod="massivo"}
        </button>
    </td>
</tr>