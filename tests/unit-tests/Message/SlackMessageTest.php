<?php
/**
 * This file is part of Parkingcrew.
 *
 * (c) Team Internet AG
 *
 * @Author: ronny
 * @Date: 05.08.16
 */

namespace Sleipi\Monolog2Slack\Message;


class SlackMessageTest extends \PHPUnit_Framework_TestCase
{
    public function setAndGetProvider()
    {
        return [
            ['fallback', 'a_string'],
            ['pretext', 'a_string'],
            ['text', 'a_string'],
            ['color', '#00FF00'],
            ['footer', 'a_string'],
            ['footerIcon', 'a_string'],
            ['title', 'a_string'],
            ['titleLink', 'a_string'],
            ['date', new \DateTime('yesterday')]
        ];
    }

    /**
     * @dataProvider setAndGetProvider
     */
    public function testSetAndGet($method, $data)
    {
        $message = new SlackMessage();

        $setter = 'set' . ucfirst($method);
        $getter = 'get' . ucfirst($method);
        $this->assertInstanceOf(SlackMessage::class, $message->$setter($data));
        $this->assertEquals($data, $message->$getter());
    }

    public function testAppendAndGetFields()
    {
        $fieldMock = $this->createMock(Field::class);
        $message = new SlackMessage();
        $this->assertInstanceOf(
            SlackMessage::class,
            $message->appendField($fieldMock)
        );

        $fieldList = $message->getFields();
        $this->assertEquals(1, count($fieldList));
        $this->assertInstanceOf(Field::class, $fieldList[0]);
    }

    public function testOverwriteSettings()
    {
        $message = new SlackMessage();
        $message
            ->setFallback('old')
            ->setPretext('old')
            ->setText('old')
            ->setColor('#000000')
            ->setFooter('old')
            ->setFooterIcon('old')
            ->setTitle('old')
            ->setTitleLink('old')
            ->setDate(new \DateTime('2016-07-01'));
        $message->appendField($this->createMock(Field::class));

        $overwriteWith = new SlackMessage();
        $overwriteWith
            ->setFallback('new')
            ->setPretext('new')
            ->setText('new')
            ->setColor('#FFFFFF')
            ->setFooter('new')
            ->setFooterIcon('new')
            ->setTitle('new')
            ->setTitleLink('new')
            ->setDate(new \DateTime('2017-07-01'));
        $message->appendField($this->createMock(Field::class));

        $message->overwriteSettings($overwriteWith);

        $this->assertEquals('new', $message->getFallback());
        $this->assertEquals('new', $message->getPretext());
        $this->assertEquals('new', $message->getText());
        $this->assertEquals('#FFFFFF', $message->getColor());
        $this->assertEquals('new', $message->getFooter());
        $this->assertEquals('new', $message->getFooterIcon());
        $this->assertEquals('new', $message->getTitle());
        $this->assertEquals('new', $message->getTitleLink());
        $this->assertEquals(new \DateTime('2017-07-01'), $message->getDate());
        $this->assertEquals(2, count($message->getFields()));
    }

    public function testRender()
    {
        $message = new SlackMessage();

        $message
            ->setFallback('old')
            ->setPretext('old')
            ->setText('old')
            ->setColor('#000000')
            ->setFooter('old')
            ->setFooterIcon('old')
            ->setTitle('old')
            ->setTitleLink('old')
            ->setDate(new \DateTime('1982-07-01'));
        $message->appendField((new Field())->setTitle('1')->setValue('2'));

        $this->assertEquals(
            [
                'fallback' => 'old',
                'color' => '#000000',
                'text' => 'old',
                'ts' => 394329600,
                'pretext' => 'old',
                'footer' => 'old',
                'footer_icon' => 'old',
                'title' => 'old',
                'fields' => [
                    [
                        'title' => '1',
                        'value' => '2',
                        'short' => true
                    ]
                ]
            ],
            $message->render()
        );
    }
}
