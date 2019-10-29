<?php

namespace Tests\Unit\Clients\Concerns\HandlesExceptions;

use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;

class StubException extends RuntimeException implements GuzzleException
{
}
