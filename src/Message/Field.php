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

namespace Sleipi\Monolog2Slack\Message;

/**
 * Class Field
 * @package Sleipi\Monolog2Slack\Message
 */
class Field
{

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $value;

    /**
     * @var bool
     */
    private $short = true;

    /**
     * @param string $title
     * @return Field
     */
    public function setTitle(string $title): Field
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @param string $value
     * @return Field
     */
    public function setValue(string $value): Field
    {
        $this->value = $value;
        return $this;
    }

    /**
     * @param boolean $short
     * @return Field
     */
    public function setShort(bool $short = true): Field
    {
        $this->short = $short;
        return $this;
    }

    /**
     * @return array
     */
    public function render() : array
    {
        return [
            'title' => $this->title,
            'value' => $this->value,
            'short' => $this->short,
        ];
    }
}