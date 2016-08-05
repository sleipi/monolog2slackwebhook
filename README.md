Slack Webhook Handler for Monolog
=================================

[![Build Status](https://travis-ci.org/sleipi/monolog2slackwebhook.svg?branch=master)](https://travis-ci.org/sleipi/monolog2slackwebhook)

Monolog Handler to push log messages to a slack webhook.

# Preview

![Send Log Messages to Slack][preview]

# Usage

```php
//define your slack webhook Url
$slackWebhookUrl = "https://hooks.slack.com/services/<token>";

// let's build our Handler
$slack = new SlackWebhookHandler(
    $slackWebhookUrl, \Monolog\Logger::DEBUG
);

// configure how your Slack Message should look like
$initSlackMessage = (new SlackMessage())
    ->setFooter("PubTonic")
    ->setFooterIcon("https://tonic.com/img/social/202x202.png");

// ... create a SlackMessageFormater
$slack->setFormatter(new SlackMessageFormatter($initSlackMessage));

// ... finally we can build a Logger Object
$logger = new \Monolog\Logger('slack', [$slack]);

// ... and do some logging
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
```

[preview]: https://raw.githubusercontent.com/sleipi/monolog2slackwebhook/master/example/slack_example.png
