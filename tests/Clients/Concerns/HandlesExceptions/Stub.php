<?php

namespace Tests\Clients\Concerns\HandlesExceptions;

use Xedi\SendGrid\Clients\Concerns\HandlesExceptions;

class Stub
{
    use HandlesExceptions {
        handleException as public;
        handleClientException as public;
        handleBadRequestException as public;
        handleSendGridError as public;
    }
}
