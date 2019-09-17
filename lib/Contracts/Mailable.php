<?php

namespace Xedi\SendGrid\Contracts;

use Xedi\SendGrid\Contracts\Client;
use Xedi\SendGrid\Contracts\Response;

/**
 * @internal Mailable
 */
interface Mailable
{
    /**
     * Validate the Mailable is sufficiently setup to be sent
     *
     * @return void
     */
    public function validate(): void;

    /**
     * Send the Mailable
     *
     * @param  Client\Client $client Transmission Adapter
     *
     * @return Response An implementation of the Response contract
     */
    public function send(Client\Client $client): Response;

    /**
     * Add a Recipient
     *
     * @param string      $email_address Email address of the intended recipient
     * @param string|null $name          Name of the intended recipient
     */
    public function addRecipient(string $email_address, string $name = null): self;

    /**
     * Add multiple Recipients at once
     *
     * ```php
     * $mailable->addRecipients(
     *     [
     *         ['test@test.com', 'Test Person'],
     *     ]
     * );
     * ```
     *
     * @param array  $recipients Array of Recipients
     */
    public function addRecipients(array $recipients): self;

    /**
     * Add some content to the Mailable class
     *
     * @param string $mime_type Type of content to add
     * @param string $content   The actual content
     */
    public function addContent(string $mime_type, string $content): self;

    /**
     * Alias for adding plaintext content
     *
     * @param string $content The actual content
     */
    public function addTextContent(string $content): self;

    /**
     * Alias for adding HTML content
     *
     * @param string $content The actual content
     */
    public function addHtmlContent(string $content): self;

    /**
     * Set the Sender
     *
     * @param string      $email_address Email address of the Sender
     * @param string|null $name          Name of the Sender
     */
    public function setSender(string $email_address, string $name = null): self;

    /**
     * Set the Subject for the Mailable
     *
     * @param string $subject Mailable Subject
     */
    public function setSubject(string $subject): self;
}
