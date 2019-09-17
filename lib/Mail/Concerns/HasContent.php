<?php

namespace Xedi\SendGrid\Mail\Concerns;

use Xedi\SendGrid\Mail\Entities\Content;

trait HasContent
{
    protected $content = [];

    /**
     * Add some content to the Mailable class
     *
     * @param string $mime_type Type of content to add
     * @param string $content   The actual content
     */
    public function addContent(string $mime_type, string $content): self
    {
        $this->content[] = new Content($mime_type, $content);

        return $this;
    }

    /**
     * Alias for adding plaintext content
     *
     * @param string $content The actual content
     */
    public function addTextContent(string $content): self
    {
        $this->content[] = new Content('text/plain', $content);

        return $this;
    }

    /**
     * Alias for adding HTML content
     *
     * @param string $content The actual content
     */
    public function addHtmlContent(string $content): self
    {
        $this->content[] = new Content('text/html', $content);

        return $this;
    }
}
