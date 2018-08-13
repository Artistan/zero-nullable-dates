<?php

namespace Artistan\ZeroNullDates;

use Illuminate\Support\Facades\Facade as IllFacade;

class Facade extends IllFacade
{
    protected static function getFacadeAccessor()
    {
        return 'ZeroNullDates';
    }
}
