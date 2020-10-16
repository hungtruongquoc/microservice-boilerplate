<?php

namespace Hungtruong\JobModel\Tests;

use Orchestra\Testbench\TestCase;
use Hungtruong\JobModel\JobModelServiceProvider;

class ExampleTest extends TestCase
{

    protected function getPackageProviders($app)
    {
        return [JobModelServiceProvider::class];
    }
    
    /** @test */
    public function true_is_true()
    {
        $this->assertTrue(true);
    }
}
