<?php

namespace Verifiedit\ClicksendSms;

use Psr\Http\Message\RequestInterface;

class Middleware
{
    public static function authorization(string $username, string $password): callable
    {
        return function (callable $handler) use ($username, $password) {
            return function (RequestInterface $request, array $options) use ($handler, $username, $password) {
                $token = base64_encode("$username:$password");
                $request = $request->withHeader('Authorization', "Basic $token");

                return $handler($request, $options);
            };
        };
    }

    public static function asJson(): callable
    {
        return function (callable $handler) {
            return function (RequestInterface $request, array $options) use ($handler) {
                $request = $request->withHeader('Content-Type', 'application/json');

                return $handler($request, $options);
            };
        };
    }
}