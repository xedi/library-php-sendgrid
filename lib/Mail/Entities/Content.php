<?php

namespace Xedi\SendGrid\Mail\Entities;

use Xedi\SendGrid\Mail\Entities\Entity;

/**
 * Content Class
 * @package Xedi\SendGrid\Mail\Entities\Content
 */
class Content extends Entity
{
    /**
     * @param string $mime_type  A Mime Type
     * @param string $content    Content of the Email
     */
    public function __construct(string $mime_type, string $content)
    {
        parent::__construct([
            'type' => $mime_type,
            'value' => $content
        ]);
    }
}
