<?php

namespace Xedi\SendGrid\Contracts;

use Xedi\SendGrid\Contracts\Clients\Client;
use Xedi\SendGrid\Contracts\Clients\Response;
use Xedi\SendGrid\Mail\Entities\Sender;

/**
 * Mailable Contract
 *
 * @package  Xedi\SendGrid\Contracts
 * @author   Chris Smith <chris@xedi.com>
 */
interface Mailable
{
    /**
     * Validate the Mailable is sufficiently setup to be sent
     *
     * @return static
     */
    public function validate();

    /**
     * Send the Mailable
     *
     * @param Client\Client $client Transmission Adapter
     *
     * @return Response An implementation of the Response contract
     */
    public function send(Client $client): Response;

    /**
     * Add a Recipient
     *
     * @param string      $email_address Email address of the intended recipient
     * @param string|null $name          Name of the intended recipient
     *
     * @return static
     */
    public function addRecipient(string $email_address, string $name = null);

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
     * @param array $recipients Array of Recipients
     *
     * @return static
     */
    public function addRecipients(array $recipients);

    /**
     * Get the Recipients Property
     *
     * @return array Array of Recipient objects
     */
    public function getRecipients(): array;

    /**
     * Check whether any recipients have been provider
     *
     * @return boolean
     */
    public function hasRecipients(): bool;

    /**
     * Validate the Recipients property
     *
     * @throws Xedi\SendGrid\Exceptions\RecipientValidationException
     * @return static
     */
    public function validateRecipients();

    /**
     * Build the Recipients data for the API request
     *
     * @return array API data
     */
    public function buildRecipients(): array;

    /**
     * Add some content to the Mailable class
     *
     * @param string $mime_type Type of content to add
     * @param string $content   The actual content
     *
     * @return static
     */
    public function addContent(string $mime_type, string $content);

    /**
     * Get the Content of the Mailable
     *
     * @return array Array of Content objects
     */
    public function getContent(): array;

    /**
     * Alias for adding plaintext content
     *
     * @param string $content The actual content
     *
     * @return static
     */
    public function addTextContent(string $content);

    /**
     * Alias for adding HTML content
     *
     * @param string $content The actual content
     *
     * @return static
     */
    public function addHtmlContent(string $content);

    /**
     * Check whether any content has been provided
     *
     * @return boolean
     */
    public function hasContent(): bool;

    /**
     * Validate the Content attribute
     *
     * @throws Xedi\SendGrid\Exceptions\ContentValidationException
     * @return static
     */
    public function validateContent();

    /**
     * Build Content
     *
     * @return array Content block of the api request
     */
    public function buildContent(): array;

    /**
     * Set the Sender
     *
     * @param string      $email_address Email address of the Sender
     * @param string|null $name          Name of the Sender
     *
     * @return static
     */
    public function setSender(string $email_address, string $name = null);

    /**
     * Get the Mailable's Sender
     *
     * @return Sender Associated Sender object
     */
    public function getSender(): ?Sender;

    /**
     * Check whether the sender property has been set
     *
     * @return boolean
     */
    public function hasSender(): bool;

    /**
     * Validate the Sender property
     *
     * @return static
     */
    public function validateSender();

    /**
     * Build the Sender data for the API Request
     *
     * @return array API data
     */
    public function buildSender(): array;

    /**
     * Set the Subject for the Mailable
     *
     * @param string $subject Mailable Subject
     *
     * @return static
     */
    public function setSubject(string $subject);

    /**
     * Get the Subject for the Mailable
     *
     * @return string|null
     */
    public function getSubject(): ?string;

    /**
     * Check whether the subject property has been set
     *
     * @return boolean
     */
    public function hasSubject(): bool;

    /**
     * Validate the Mailable's Subject
     *
     * @throws Xedi\SendGrid\Exceptons\SubjectValidationException
     *
     * @return static
     */
    public function validateSubject();

    /**
     * Build the Subject data for the API Request
     *
     * @return string API data
     */
    public function buildSubject(): array;
}
