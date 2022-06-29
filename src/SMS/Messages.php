<?php

namespace Verifiedit\ClicksendSms\SMS;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class Messages implements Arrayable
{
    private array|Collection|null $items;

    public function __construct(array|Collection $items = null)
    {
        if ($items instanceof Collection) {
            $this->items = $items;
        } else {
            $this->items = Collection::make($items);
        }
    }

    public function add(Message $message): Messages
    {
        $this->items->add($message);

        return $this;
    }

    #[ArrayShape(['messages' => "array"])]
    public function toArray(): array
    {
        return [
            'messages' => $this->items->toArray(),
        ];
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}