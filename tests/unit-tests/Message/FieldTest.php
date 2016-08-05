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


class FieldTest extends \PHPUnit_Framework_TestCase
{

    public function testSetTitle()
    {
        $field = new Field();
        $this->assertInstanceOf(Field::class, $field->setTitle('Test'));
    }

    public function testSetValue()
    {
        $field = new Field();
        $this->assertInstanceOf(Field::class, $field->setValue('Test'));
    }

    public function testSetShort()
    {
        $field = new Field();
        $this->assertInstanceOf(Field::class, $field->setShort());
    }

    public function testRender()
    {
        $field = new Field();
        $field->setTitle('title')->setValue('value')->setShort(false);
        $this->assertEquals(
            [
                'title' => 'title',
                'value' => 'value',
                'short' => false,
            ],
            $field->render()
        );
    }
}
