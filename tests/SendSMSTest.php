<?php

namespace Tests\Verifiedit\ClicksendSms;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Verifiedit\ClicksendSms\SMS\Message;
use Verifiedit\ClicksendSms\SMS\Messages;
use Verifiedit\ClicksendSms\SMS\RecipientAlreadySetException;
use Verifiedit\ClicksendSms\SMS\SMS;

class SendSMSTest extends TestCase
{
    /**
     * @throws GuzzleException
     * @throws RecipientAlreadySetException
     */
    public function testCanSendSMS(): void
    {
        $mock = new MockHandler(
            [
                new Response(
                    200,
                    [],
                    <<<BODY
{
  "http_code": 200,
  "response_code": "SUCCESS",
  "response_msg": "Messages queued for delivery.",
  "data": {
    "total_price": 0.0715,
    "total_count": 1,
    "queued_count": 1,
    "messages": [
      {
        "direction": "out",
        "date": 1656044743,
        "to": "+61409331111",
        "body": "Test message",
        "from": "Verified",
        "schedule": 1656044743,
        "message_id": "179E18EF-1557-4F71-AB82-D747205DBD85",
        "message_parts": 1,
        "message_price": "0.0715",
        "from_email": null,
        "list_id": null,
        "custom_string": "capture",
        "contact_id": null,
        "user_id": 200944,
        "subaccount_id": 229507,
        "country": "AU",
        "carrier": "Telstra",
        "status": "SUCCESS"
      }
    ],
    "_currency": {
      "currency_name_short": "AUD",
      "currency_prefix_d": "$",
      "currency_prefix_c": "c",
      "currency_name_long": "Australian Dollars"
    }
  }
}
BODY
,
                ),
            ]
        );
        $handlerStack = HandlerStack::create($mock);
        $client = new Client(['handler' => $handlerStack]);

        $api = new SMS($client);

        $messages = new Messages();
        $messages->add((new Message('Test'))->setTo('+61411111111'));

        $response = $api->send($messages);

        $this->assertEquals(
            [
                "http_code" => 200,
                "response_code" => "SUCCESS",
                "response_msg" => "Messages queued for delivery.",
                "data" => [
                    "total_price" => 0.0715,
                    "total_count" => 1,
                    "queued_count" => 1,
                    "messages" => [
                        [
                            "direction" => "out",
                            "date" => 1656044743,
                            "to" => "+61409331111",
                            "body" => "Test message",
                            "from" => "Verified",
                            "schedule" => 1656044743,
                            "message_id" => "179E18EF-1557-4F71-AB82-D747205DBD85",
                            "message_parts" => 1,
                            "message_price" => "0.0715",
                            "from_email" => null,
                            "list_id" => null,
                            "custom_string" => "capture",
                            "contact_id" => null,
                            "user_id" => 200944,
                            "subaccount_id" => 229507,
                            "country" => "AU",
                            "carrier" => "Telstra",
                            "status" => "SUCCESS",
                        ],
                    ],
                    "_currency" => [
                        "currency_name_short" => "AUD",
                        "currency_prefix_d" => "$",
                        "currency_prefix_c" => "c",
                        "currency_name_long" => "Australian Dollars",
                    ],
                ],
            ],
            json_decode($response->getBody()->getContents(), true)
        );
    }
}
