<?php

namespace Christoxz\InfiniteflightLive\Facades;

use Illuminate\Support\Facades\Facade;

class InfiniteflightLive extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'infiniteflight-live';
    }
}
