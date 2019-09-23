<?php

namespace Tests\SendGrid;

use Mockery;
use ReflectionProperty;
use Tests\TestCase;
use Xedi\SendGrid\Contracts\Clients\Client as ClientContract;
use Xedi\SendGrid\Contracts\Clients\Response as ResponseContract;
use Xedi\SendGrid\Contracts\Mailable as MailableContract;
use Xedi\SendGrid\SendGrid;

class SendTest extends TestCase
{
    /**
     * @test
     */
    public function positive()
    {
        $mock_response = Mockery::mock(ResponseContract::class);
        $mock_client = Mockery::mock(ClientContract::class);
        ($mock_mailable = Mockery::mock(MailableContract::class))
            ->shouldReceive('send')
            ->once()
            ->with($mock_client)
            ->andReturn($mock_response);

        ($reflection = new ReflectionProperty(SendGrid::class, 'client'))
            ->setAccessible(true);
        $reflection->setValue(null, $mock_client);

        $response = SendGrid::send($mock_mailable);

        $this->assertInstanceOf(ResponseContract::class, $response);
    }
}
