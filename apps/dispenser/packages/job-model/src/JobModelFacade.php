<?php

namespace Hungtruong\JobModel;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Hungtruong\JobModel\Skeleton\SkeletonClass
 */
class JobModelFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'job-model';
    }
}
