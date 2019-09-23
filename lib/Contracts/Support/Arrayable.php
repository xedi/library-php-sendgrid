<?php

namespace Xedi\SendGrid\Contracts\Support;

/**
 * Arrayable Interface
 *
 * @internal
 * @package  Xedi\SendGrid\Contracts\Support
 * @author   Chris Smith <chris@xedi.com>
 */
interface Arrayable
{
    /**
     * Get the instance as an array.
     *
     * @return array
     */
    public function toArray();
}
