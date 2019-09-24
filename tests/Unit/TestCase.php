<?php

namespace Tests\Unit;

use Mockery;
use Tests\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    public function tearDown(): void
    {
        Mockery::close();
    }
}
