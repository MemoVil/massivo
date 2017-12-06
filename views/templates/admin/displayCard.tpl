 <div class="col-sm-6 col-md-4 col-lg-3 mt-4">
    <div class="card" recipeid="{$id}">       
        <div class="card-block">            
            <h4 class="card-title mt-3"><span class="icon-book"></span>
                {l s="Recipe" mod="massivo"} {$pos}
            </h4>            
            <div class="meta">
                <h5> {$text}</h5>               
            </div>            
        </div>
        <div class="card-footer text-center">           
            <div class="icon pull-right hidden">
               <a href="#"><i class="fa fa-envelope fa-fw fa-2x" aria-hidden="true"></i></a>
                <a href="#"><i class="fa fa-ban fa-2x" aria-hidden="true"></i></a>

            </div>
            <button type="button" class="btn btn-default editrecipe" recipeid="{$id}">{l s="Edit" mod="massivo"}</button>
            <button type="button" class="btn btn-default deleterecipe" recipeid="{$id}">{l s="Delete" mod="massivo"}</button>
        </div>
    </div>
</div>