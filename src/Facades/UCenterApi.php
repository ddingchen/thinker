<?php 

namespace Thinker\Facades;

use Illuminate\Support\Facades\Facade;
use Thinker\Testing\UCenterApiFake;
use Thinker\UCenterApi as Origin;

class UCenterApi extends Facade
{

    /**
     * Replace the bound instance with a fake.
     *
     * @return void
     */
    public static function fake()
    {
        $fake = app(UCenterApiFake::class);
        
        static::swap($fake);

        return $fake;
    }

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
