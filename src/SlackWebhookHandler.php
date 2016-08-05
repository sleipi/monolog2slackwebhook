<?php
/**
 * This file is part of monolog2slackwebhook repository
 *
 * (c) Ronny Herrgesell
 *
 * For the full copyright and license information, please view the LICENSE
 *
 * @Author: ronny
 * @Date: 05.08.16
 */
namespace Sleipi\Monolog2Slack;

use Curl\Curl;
use Monolog\Handler\AbstractHandler;

/**
 * Class SlackWebhookHandler
 * @package Sleipi\Monolog2Slack
 */
class SlackWebhookHandler extends AbstractHandler
{
    /**
     * @var int
     */
    private $webhookUrl;

    /**
     * @var Curl
     */
    private $curlHandler;

    /**
     * SlackWebhookHandler constructor.
     * @param int $webHookUrl
     * @param bool $level
     * @param $bubble
     */
    public function __construct($webHookUrl, $level, $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->webhookUrl = $webHookUrl;
    }

    /**
     * @param Curl $curl
     * @return SlackWebhookHandler
     */
    public function setCurlHandler(Curl $curl) : SlackWebhookHandler
    {
        $this->curlHandler = $curl;
        return $this;
    }

    /**
     * @param array $record
     *
     * @return bool|void
     */
    public function handle(array $record)
    {
        if (!$this->isHandling($record)) {
            return false;
        }

        $curl = $this->getCurlHandler();
        $curl->post(
            $this->webhookUrl,
            ['payload' => json_encode($this->buildPayload($record))]
        );
        return true;
    }

    /**
     * @return Curl
     */
    private function getCurlHandler() : Curl
    {
        // @codeCoverageIgnoreStart
        if (is_null($this->curlHandler)) {
            $this->curlHandler = new Curl();
        }
        // @codeCoverageIgnoreEnd
        return $this->curlHandler;
    }

    /**
     * @param array $record
     * @return array
     */
    private function buildPayload(array $record) : array
    {
        $formatter = $this->getFormatter();
        return [
            'attachments' => [$formatter->format($record)]
        ];
    }
}