<?php

namespace App\Traits ;

use App\Models\Store;

trait FunctionTrait{


    public function getStoreByDomain($shop){

        return Store::where('shopify_domain',$shop)->first();
    }
}
