<?php

namespace Tests\SendGrid;

use Mockery;
use ReflectionProperty;
use Tests\TestCase;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\SendGrid;

class SetClientTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $mock_client = Mockery::mock(ClientContract::class);

        SendGrid::setClient($mock_client);

        ($reflection = new ReflectionProperty(SendGrid::class, 'client'))
            ->setAccessible(true);

        $this->assertEquals($mock_client, $reflection->getValue());
    }
}
