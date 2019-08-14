<?php

namespace Blok\Mock\Tests;

use Blok\Mock\ServiceProvider;

class MockTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [ServiceProvider::class];
    }

    protected function getPackageAliases($app)
    {
        return [
            'mock' => \Blok\Mock\Mock::class,
        ];
    }

    public function testExample()
    {
        $this->assertEquals(1, 1);
    }
}
