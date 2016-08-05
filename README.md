Slack Webhook Handler for Monolog
=================================

Monolog Handler to push log Messages to a Slack Webhook.

# Usage

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
