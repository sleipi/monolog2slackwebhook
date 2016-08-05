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

use Monolog\Formatter\FormatterInterface;
use Monolog\Logger;
use Sleipi\Monolog2Slack\Message\Field;
use Sleipi\Monolog2Slack\Message\SlackMessage;

/**
 * Class SlackMessageFormatter
 * @package Sleipi\Monolog2Slack
 */
class SlackMessageFormatter implements FormatterInterface
{
    /**
     * @var SlackMessage
     */
    private $slackMessage;

    /**
     * @var array
     */
    private $color = [
        Logger::DEBUG => '#b3b3cc',
        Logger::INFO => '#009933',
        Logger::NOTICE => '#003399',
        Logger::WARNING => '#ff9900',
        Logger::ERROR => '#cc0000',
        Logger::CRITICAL => '#cc0000',
        Logger::ALERT => '#cc0000',
        Logger::EMERGENCY => '#cc0000',
    ];

    /**
     * SlackMessageFormatter constructor.
     * @param SlackMessage $initialMessage
     * @param array $colorMap
     */
    public function __construct(SlackMessage $initialMessage, array $colorMap = [])
    {
        $this->slackMessage = $initialMessage;

        if (count($colorMap) == count(Logger::getLevels())) {
            $this->color = $colorMap;
        }
    }

    /**
     * @param array $record
     * @return array
     */
    public function format(array $record) : array
    {
        $usedSlackMessage = clone $this->slackMessage;

        foreach ($record['context'] as $context) {
            if ($context instanceof Field) {
                $usedSlackMessage->appendField($context);
            }

            if ($context instanceof SlackMessage) {
                $context->overwriteSettings($usedSlackMessage);
                $usedSlackMessage = $context;
            }
        }

        return $usedSlackMessage
            ->setText($record['message'])
            ->setColor($this->getColor($record['level']))
            ->setDate($record['datetime'])
            ->render();
    }

    /**
     * @param int $logLevel
     * @return string
     */
    private function getColor(int $logLevel) : string
    {
        if (!isset($this->color[$logLevel])) {
            throw new \RuntimeException('No color specified for Log Level "' . $logLevel . '"');
        }

        return $this->color[$logLevel];
    }

    /**
     * @param array $records
     * @return array
     */
    public function formatBatch(array $records)
    {
        return $records;
    }
}