<?php

namespace Verifiedit\ClicksendSms\Exceptions;

use Exception;
use GuzzleHttp\Exception\RequestException;
use Throwable;

class ClicksendApiException extends Exception
{
    private array $responseHeaders;
    private ?string $responseBody;

    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }

    public static function fromException(
        string $message = "",
        int $code = 0,
        ?Throwable $previous = null
    ): ClicksendApiException {
        $exception = new ClicksendApiException($message, $code, $previous);

        $exception->responseHeaders =
            $previous instanceof RequestException ? $previous->getResponse()->getHeaders() : [];
        $exception->responseBody =
            $previous instanceof RequestException ? $previous->getResponse()->getBody()->getContents() : null;

        return $exception;
    }

    public static function fromResponse(
        string $message = "",
        int $code = 0,
        array $responseHeaders = [],
        ?string $responseBody = null
    ): ClicksendApiException {
        $exception = new ClicksendApiException($message, $code);

        $exception->responseHeaders = $responseHeaders;
        $exception->responseBody = $responseBody;

        return $exception;
    }

    /**
     * @return array
     */
    public function getResponseHeaders(): array
    {
        return $this->responseHeaders;
    }

    public function getResponseBody(): ?string
    {
        return $this->responseBody;
    }
}