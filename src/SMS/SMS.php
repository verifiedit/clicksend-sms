<?php

namespace Verifiedit\ClicksendSms\SMS;

use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\ResponseInterface;
use Verifiedit\ClicksendSms\Exceptions\ClicksendApiException;

class SMS
{
    private ClientInterface $client;

    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws ClicksendApiException
     * @throws GuzzleException
     */
    public function send(Messages $messages): ResponseInterface
    {
        try {
            $request = new Request(
                'POST',
                '/sms/send',
                [],
                $messages,
            );

            $response = $this->client->send($request);
        } catch (RequestException $exception) {
            throw ClicksendApiException::fromException(
                "[{$exception->getCode()}] {$exception->getMessage()}",
                $exception->getCode(),
                $exception
            );
        }

        $statusCode = $response->getStatusCode();

        if ($statusCode < 200 || $statusCode > 299) {
            throw ClicksendApiException::fromResponse(
                sprintf('[%d] Error connecting to the API (%s)', $statusCode, $request->getUri()),
                $statusCode,
                $response->getHeaders(),
                (string)$response->getBody()
            );
        }

        return $response;
    }
}