<?php

namespace Verifiedit\ClicksendSms\SMS;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Psr\Http\Message\ResponseInterface;

class SMS
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws GuzzleException
     */
    public function send(Messages $messages): ResponseInterface
    {
        return $this->client->request(
            'POST',
            '/sms/send',
            [
                'json' => [
                    'messages' => $messages->toArray(),
                ],
            ]
        );
    }
}