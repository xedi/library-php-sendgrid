<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SendGrid\Exceptions\ContentValidationException;
use Xedi\SendGrid\Mail\Entities\Content;

/**
 * HasContent Concern
 *
 * @package Xedi\SendGrid\Mail\Concerns
 * @author  Chris Smith <chris@xedi.com>
 */
trait HasContent
{
    protected $content = [];

    /**
     * Add some content to the Mailable class
     *
     * @param string $mime_type Type of content to add
     * @param string $content   The actual content
     *
     * @return static
     */
    public function addContent(string $mime_type, string $content)
    {
        $this->content[] = new Content($mime_type, $content);

        return $this;
    }

    /**
     * Get the Content of the Mailable
     *
     * @return array Array of Content objects
     */
    public function getContent(): array
    {
        return $this->content;
    }

    /**
     * Alias for adding plaintext content
     *
     * @param string $content The actual content
     *
     * @return static
     */
    public function addTextContent(string $content)
    {
        $this->content[] = new Content('text/plain', $content);

        return $this;
    }

    /**
     * Alias for adding HTML content
     *
     * @param string $content The actual content
     *
     * @return static
     */
    public function addHtmlContent(string $content)
    {
        $this->content[] = new Content('text/html', $content);

        return $this;
    }

    /**
     * Check whether any content has been provided
     *
     * @return boolean
     */
    public function hasContent(): bool
    {
        return ! empty($this->content) &&
            array_every($this->content, function ($item) {
                return $item instanceof Content;
            });
    }

    /**
     * Validate the Content attribute
     *
     * @throws Xedi\SendGrid\Exceptions\ContentValidationException
     * @return static
     */
    public function validateContent()
    {
        if (! $this->hasContent()) {
            throw new ContentValidationException('Missing Content Value', $this);
        }

        return $this;
    }

    /**
     * Build Content
     *
     * @return array Content block of the api request
     */
    public function buildContent(): array
    {
        return [
            'content' => array_map(
                function ($content) {
                    return $content->toArray();
                },
                $this->content
            )
        ];
    }
}
