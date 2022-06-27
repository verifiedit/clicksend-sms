<?php

namespace Tests\Verifiedit\ClicksendSms;

use DateTime;
use PHPUnit\Framework\TestCase;
use Verifiedit\ClicksendSms\SMS\Message;
use Verifiedit\ClicksendSms\SMS\RecipientAlreadySetException;

class ClicksendSMSMessageTest extends TestCase
{
    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanCreateMinimalMessage(): void
    {
        $message = new Message('Test');
        $message->setTo('+61411111111');

        $this->assertEquals(['body' => 'Test', 'to' => '+61411111111'], $message->toArray());
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplySenderId(): void
    {
        $message = new Message('Test');
        $message
            ->setFrom('Verified')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'from' => 'Verified',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplySource(): void
    {
        $message = new Message('Test');
        $message
            ->setSource('Verified')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'source' => 'Verified',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanScheduleMessage(): void
    {
        $message = new Message('Test');
        $message
            ->setSchedule(new DateTime('2000-01-01 00:00:00'))
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'schedule' => 946684800,
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplyReference(): void
    {
        $message = new Message('Test');
        $message
            ->setReference('Verified#1234')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'custom_string' => 'Verified#1234',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplyCountry(): void
    {
        $message = new Message('Test');
        $message
            ->setCountry('AU')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'country' => 'AU',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplyFromEmail(): void
    {
        $message = new Message('Test');
        $message
            ->setFromEmail('user@example.com')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'from_email' => 'user@example.com',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanApplyListId(): void
    {
        $message = new Message('Test');
        $message
            ->setListId('123456');

        $this->assertEquals(
            [
                'body' => 'Test',
                'list_id' => '123456',
            ],
            $message->toArray()
        );
    }

    public function testCannotSetListIdIfToIsSet(): void
    {
        $this->expectException(RecipientAlreadySetException::class);
        $this->expectExceptionMessage('To is already set. Can set only one recipient type.');

        $message = new Message('Test');
        $message
            ->setTo('+61411111111')
            ->setListId('123456');
    }

    public function testCannotSetToIfListIdIsSet(): void
    {
        $this->expectException(RecipientAlreadySetException::class);
        $this->expectExceptionMessage('List ID is already set. Can set only one recipient type.');

        $message = new Message('Test');
        $message
            ->setListId('123456')
            ->setTo('+61411111111');
    }

    /**
     * @throws RecipientAlreadySetException
     */
    public function testCanSetAllProperties(): void
    {
        $message = new Message('Test');
        $message
            ->setReference('Verified#1234')
            ->setCountry('AU')
            ->setFrom('Verified')
            ->setFromEmail('user@example.com')
            ->setSchedule(new DateTime('2000-01-01 00:00:00'))
            ->setSource('Verified')
            ->setTo('+61411111111');

        $this->assertEquals(
            [
                'body' => 'Test',
                'country' => 'AU',
                'custom_string' => 'Verified#1234',
                'from' => 'Verified',
                'from_email' => 'user@example.com',
                'schedule' => 946684800,
                'source' => 'Verified',
                'to' => '+61411111111',
            ],
            $message->toArray()
        );
    }
}
