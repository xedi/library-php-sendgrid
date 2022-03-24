<?php

namespace Xedi\SendGrid\Mail\Concerns;

/**
 * HasAttachment Concern
 *
 * @package Xedi\SendGrid\Mail\Concerns
 * @author  Adam Witeszczak <adam@xedi.com>
 */
trait HasAttachment
{
    protected $attachments = [];

    /**
     * Set Attachment
     *
     * @param $attachment string attachment file as string
     * @param $mime_type  string mime type
     * @param $name       string name
     *
     * @return $this
     */
    public function setAttachment($attachment, $mime_type, $name)
    {
        $toAttach = new \StdClass();
        $toAttach->content = base64_encode($attachment);
        $toAttach->type = $mime_type;
        $toAttach->filename = $name;
        $toAttach->disposition = 'attachment';
        $this->attachments[] = $toAttach;

        return $this;
    }

    /**
     * Has Attachment
     *
     * @return bool
     */
    public function hasAttachment(): bool
    {
        return count($this->attachments) > 0;
    }

    /**
     * Build the Attachment data for the API Request
     *
     * @return string API data
     */
    public function buildAttachment(): array
    {
        return [
            'attachments' => $this->attachments
        ];
    }
}
