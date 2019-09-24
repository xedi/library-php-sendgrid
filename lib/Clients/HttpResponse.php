<?php

namespace Xedi\SendGrid\Clients;

use Symfony\Component\HttpFoundation\Response;
use Xedi\SendGrid\Contracts\Clients\Response as ResponseContract;

/**
 * HttpResponse Class
 *
 * @package Xedi\SendGrid\Clients
 * @author  Chris Smith <chris@xedi.com>
 */
class HttpResponse extends Response implements ResponseContract
{
}
