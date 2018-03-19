<?php 

namespace Thinker\Facades;

use Illuminate\Support\Facades\Facade;
use Thinker\UCenter as Origin;

class UCenter extends Facade
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
