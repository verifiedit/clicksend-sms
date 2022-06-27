# Clicksend SMS

Enables sending of SMS messages through Clicksend. 

Based on official Clicksend API documentation https://developers.clicksend.com/docs/rest/v3/?shell#send-sms

## Installation

```shell
composer install verifiedit/clicksend-sms
```

## Example

```php
$messages = new \Verifiedit\ClicksendSms\SMS\Messages();
$messages->add((new \Verifiedit\ClicksendSms\SMS\Message('Test'))->setTo('+61411111111'));

$client = \Verifiedit\ClicksendSms\ClicksendClient::make('myaccount@example.com', 'secret')
$sms = new \Verifiedit\ClicksendSms\SMS\SMS($client);

$response = $sms->send($messages);
```
