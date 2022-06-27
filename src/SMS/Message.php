<?php

namespace Verifiedit\ClicksendSms\SMS;

use DateTime;
use Illuminate\Contracts\Support\Arrayable;
use JetBrains\PhpStorm\ArrayShape;

class Message implements Arrayable
{
    private ?string $body = null;
    private ?string $country = null;
    private ?string $from = null;
    private ?string $fromEmail = null;
    private ?int $listId = null;
    private ?string $reference = null;
    private ?DateTime $schedule = null;
    private ?string $source = null;
    private ?string $to = null;

    public function __construct(string $body)
    {
        $this->setBody($body);
    }

    #[ArrayShape([
        'body' => "null|string",
        "country" => "null|string",
        "from" => "null|string",
        "from_email" => "null|string",
        "list_id" => "null|int",
        "reference" => "null|string",
        "schedule" => "null|int",
        "source" => "null|string",
        "to" => "null|string",
    ])]
    public function toArray(): array
    {
        return [
            ...$this->body(),
            ...$this->country(),
            ...$this->from(),
            ...$this->fromEmail(),
            ...$this->listId(),
            ...$this->recipient(),
            ...$this->reference(),
            ...$this->schedule(),
            ...$this->source(),
        ];
    }

    public function setFrom(string $from): Message
    {
        $this->from = $from;

        return $this;
    }

    public function setBody(string $body): Message
    {
        $this->body = $body;

        return $this;
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function setTo(string $to): Message
    {
        if ($this->listId) {
            throw new RecipientAlreadySetException('List ID is already set. Can set only one recipient type.');
        }

        $this->to = $to;

        return $this;
    }

    public function setSource(string $source): Message
    {
        $this->source = $source;

        return $this;
    }

    public function setSchedule(DateTime $schedule): Message
    {
        $this->schedule = $schedule;

        return $this;
    }

    public function setReference(string $reference): Message
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function setListId(int $listId): Message
    {
        if ($this->to) {
            throw new RecipientAlreadySetException('To is already set. Can set only one recipient type.');
        }

        $this->listId = $listId;

        return $this;
    }

    public function setCountry(string $country): Message
    {
        $this->country = $country;

        return $this;
    }

    public function setFromEmail(string $fromEmail): Message
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    #[ArrayShape(['body' => "null|string"])]
    private function body(): array
    {
        return ['body' => $this->body];
    }

    private function country(): array
    {
        return $this->country ? ['country' => $this->country] : [];
    }

    private function from(): array
    {
        return $this->from ? ['from' => $this->from] : [];
    }

    private function fromEmail(): array
    {
        return $this->fromEmail ? ['from_email' => $this->fromEmail] : [];
    }

    private function listId(): array
    {
        return $this->listId ? ['list_id' => $this->listId] : [];
    }

    private function recipient(): array
    {
        if ($this->listId) {
            return [
                'list_id' => $this->listId,
            ];
        }

        return ['to' => $this->to];
    }

    private function reference(): array
    {
        return $this->reference ? ['custom_string' => $this->reference] : [];
    }

    private function schedule(): array
    {
        return $this->schedule ? ['schedule' => $this->schedule->getTimestamp()] : [];
    }

    private function source(): array
    {
        return $this->source ? ['source' => $this->source] : [];
    }
}