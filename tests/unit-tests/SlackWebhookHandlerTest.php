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


use Curl\Curl;
use Monolog\Logger;

class SlackWebhookHandlerTest extends \PHPUnit_Framework_TestCase
{

    private $lastUrl;
    private $lastPayload;

    public function setUp()
    {
        $this->lastUrl = $this->lastPayload = null;
    }

    public function testHandle_processLogMessage()
    {
        $handler = new SlackWebhookHandler('http://url', Logger::DEBUG);
        $handler->setFormatter($this->getFormatterMock());
        $handler->setCurlHandler($this->getCurlMock());


        $testData = ['text' => 'test', 'level' => Logger::DEBUG];
        $this->assertTrue($handler->handle($testData));
        $this->assertEquals('http://url', $this->lastUrl);
        $this->assertEquals(
            ['payload' => json_encode(['attachments' => [$testData]])],
            $this->lastPayload
        );
    }

    /**
     * @return SlackMessageFormatter|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getFormatterMock()
    {
        $formatterMock = $this->createMock(SlackMessageFormatter::class);
        $formatterMock->expects($this->once())
            ->method('format')
            ->willReturnArgument(0);
        return $formatterMock;
    }

    /**
     * @return Curl|\PHPUnit_Framework_MockObject_MockObject
     */
    private function getCurlMock()
    {
        $curlMock = $this->createMock(Curl::class);
        $curlMock->expects($this->once())
            ->method('post')
            ->willReturnCallback(function ($url, $payload) {
                $this->lastUrl = $url;
                $this->lastPayload = $payload;
            });
        return $curlMock;
    }

    public function testHandle_skipLogMessage()
    {
        $handler = new SlackWebhookHandler('http://url', Logger::ALERT);

        $testData = ['text' => 'test', 'level' => Logger::DEBUG];
        $this->assertFalse($handler->handle($testData));
    }
}
