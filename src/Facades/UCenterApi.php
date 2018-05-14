<?php 

namespace Thinker\Facades;

use Illuminate\Support\Facades\Facade;
use Thinker\UCenterApi as Origin;

class UCenterApi extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() 
    { 
        return Origin::class; 
    }
}
