<?php
/**
 * This file is part of Parkingcrew.
 *
 * (c) Team Internet AG
 *
 * @Author: ronny
 * @Date: 05.08.16
 */

namespace Sleipi\Monolog2Slack;


use Monolog\Logger;
use Sleipi\Monolog2Slack\Message\Field;
use Sleipi\Monolog2Slack\Message\SlackMessage;

class SlackWebhookFormatterTest extends \PHPUnit_Framework_TestCase
{

    private $testRecord;

    public function setUp()
    {
        $this->testRecord = [
            'message' => 'Text',
            'context' => [],
            'level' => Logger::DEBUG,
            'datetime' => new \DateTime('yesterday')
        ];
    }

    public function testFormat_woContext()
    {
        $slackMessage = $this->getSlackMessageMock();
        $formatter = new SlackMessageFormatter($slackMessage);

        $result = $formatter->format($this->testRecord);
        $this->assertEquals(['message'], $result);
    }

    public function testFormat_wContextFields()
    {
        $slackMessage = $this->getSlackMessageMock();
        $formatter = new SlackMessageFormatter($slackMessage);

        $this->testRecord['context'][] = $this->createMock(Field::class);

        $result = $formatter->format($this->testRecord);
        $this->assertEquals(['message'], $result);
    }

    public function testFormat_wContextSlackMessage()
    {
        $slackMessage = $this->getSlackMessageMock();
        $formatter = new SlackMessageFormatter($slackMessage);

        $this->testRecord['context'][] = $this->getSlackMessageMock();

        $result = $formatter->format($this->testRecord);
        $this->assertEquals(['message'], $result);
    }

    public function testFormatBatch()
    {
        $slackMessage = $this->getSlackMessageMock();
        $formatter = new SlackMessageFormatter($slackMessage);

        $this->assertEquals($this->testRecord, $formatter->formatBatch($this->testRecord));
    }


### EDGE CASES

    /**
     * @expectedException \RuntimeException
     */
    public function testFormat_invalidColor()
    {
        $slackMessage = $this->getSlackMessageMock();
        $formatter = new SlackMessageFormatter($slackMessage);

        $this->testRecord['level'] = 10000;
        $formatter->format($this->testRecord);
    }

    /**
     * @return SlackMessage|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getSlackMessageMock()
    {
        $slackMessage = $this->createMock(SlackMessage::class);
        $slackMessage->method('setText')
            ->willReturnSelf();
        $slackMessage->method('setColor')
            ->willReturnSelf();
        $slackMessage->method('setDate')
            ->willReturnSelf();

        $slackMessage->method('render')
            ->willReturn(['message']);

        return $slackMessage;
    }
}
