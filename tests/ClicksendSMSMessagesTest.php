<?php

namespace Tests\Verifiedit\ClicksendSms;

use PHPUnit\Framework\TestCase;
use Verifiedit\ClicksendSms\SMS\Message;
use Verifiedit\ClicksendSms\SMS\Messages;
use Verifiedit\ClicksendSms\SMS\RecipientAlreadySetException;

class ClicksendSMSMessagesTest extends TestCase
{
    /**
     * @throws RecipientAlreadySetException
     */
    public function testItCanCreateMessages(): void
    {
        $messages = new Messages(
            [
                (new Message('Test'))->setTo('+61411111111'),
                (new Message('Test 2'))->setTo('+61411111111'),
            ],
        );

        $this->assertEquals(
            [
                ['body' => 'Test', 'to' => '+61411111111'],
                ['body' => 'Test 2', 'to' => '+61411111111'],
            ],
            $messages->toArray()
        );
    }
}
