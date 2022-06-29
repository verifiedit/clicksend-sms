<?php

namespace Verifiedit\ClicksendSms;

use GuzzleHttp\Client;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Utils;

class ClicksendClient
{
    private string $username;
    private string $password;

    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    public static function make(string $username, string $password): Client
    {
        return (new ClicksendClient($username, $password))->client();
    }

    public function client(): Client
    {
        return new Client(
            [
                'base_uri' => 'https://rest.clicksend.com/v3',
                'handler' => $this->handler(),
            ]
        );
    }

    private function handler(): HandlerStack
    {
        $stack = new HandlerStack();
        $stack->setHandler(Utils::chooseHandler());
        $stack->push(Middleware::asJson());
        $stack->push(Middleware::authorization($this->username, $this->password));

        return $stack;
    }
}