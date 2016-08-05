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

use Sleipi\Monolog2Slack\Message\SlackMessage;
use Sleipi\Monolog2Slack\Message\Field;
use Sleipi\Monolog2Slack\SlackMessageFormatter;
use Sleipi\Monolog2Slack\SlackWebhookHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$slackWebhookUrl = "https://hooks.slack.com/services/<token>";

$initSlackMessage = (new SlackMessage())
    ->setFooter("PubTonic")
    ->setFooterIcon("https://tonic.com/img/social/202x202.png");

$slack = new SlackWebhookHandler(
    $slackWebhookUrl, \Monolog\Logger::DEBUG
);
$slack->setFormatter(new SlackMessageFormatter($initSlackMessage));

$logger = new \Monolog\Logger('slack', [$slack]);
$logger->debug("My Debug <http://www.foo.com|Link>");
$logger->info('My Info Message', [
    (new Field())->setTitle('Priority')->setValue('Small Info'),
    (new Field())->setTitle('Info')->setValue('Another small Info')
]);
$logger->notice('My Notice Message', [
    (new SlackMessage())->setPretext('Irgendwas ist passiert')
]);
$logger->warning("My Multiline\nWarning Message");
$logger->error('My Error Message for <!everyone>');
