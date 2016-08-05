<?php

namespace Sleipi\Monolog2Slack\Message;

use DateTime;

/**
 * This file is part of Parkingcrew.
 *
 * (c) Team Internet AG
 *
 * @Author: ronny
 * @Date: 05.08.16
 */
class SlackMessage
{
    /**
     * @var string
     */
    private $fallback = '';

    /**
     * @var string
     */
    private $pretext = '';

    /**
     * @var string
     */
    private $text = '';

    /**
     * @var string
     */
    private $color = '#000000';

    /**
     * @var string
     */
    private $footer = '';

    /**
     * @var string
     */
    private $footerIcon = '';

    /**
     * @var string
     */
    private $title = '';

    /**
     * @var string
     */
    private $titleLink = '';

    /**
     * @var DateTime
     */
    private $date;

    /**
     * @var Field[]
     */
    private $field = [];

    /**
     * SlackMessage constructor.
     */
    public function __construct()
    {
        $this->date = new DateTime('now');
    }

    /**
     * @param Field $field
     * @return SlackMessage
     */
    public function appendField(Field $field) : SlackMessage
    {
        $this->field[] = $field;
        return $this;
    }

    /**
     * @param SlackMessage $attachment
     */
    public function overwriteSettings(SlackMessage $attachment)
    {
        $this->fallback = $attachment->getFallback() ?? $this->getFallback();
        $this->pretext = $attachment->getPretext() ?? $this->getPretext();
        $this->text = $attachment->getText() ?? $this->getText();
        $this->color = $attachment->getColor() ?? $this->getColor();
        $this->footer = $attachment->getFooter() ?? $this->getFooter();
        $this->footerIcon = $attachment->getFooterIcon() ?? $this->getFooterIcon();
        $this->title = $attachment->getTitle() ?? $this->getTitle();
        $this->titleLink = $attachment->getTitleLink() ?? $this->getTitleLink();
        $this->date = $attachment->getDate() ?? $this->getDate();

        $this->field = $attachment->getFields() + $this->field;
    }

    /**
     * @return string
     */
    public function getFallback(): string
    {
        return $this->fallback;
    }

    /**
     * @param string $fallback
     * @return SlackMessage
     */
    public function setFallback(string $fallback): SlackMessage
    {
        $this->fallback = $fallback;
        return $this;
    }

    /**
     * @return string
     */
    public function getPretext(): string
    {
        return $this->pretext;
    }

    /**
     * @param string $pretext
     * @return SlackMessage
     */
    public function setPretext(string $pretext): SlackMessage
    {
        $this->pretext = $pretext;
        return $this;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return SlackMessage
     */
    public function setText(string $text): SlackMessage
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return string
     */
    public function getColor(): string
    {
        return $this->color;
    }

    /**
     * @param string $color
     * @return SlackMessage
     */
    public function setColor(string $color): SlackMessage
    {
        $this->color = $color;
        return $this;
    }

    /**
     * @return string
     */
    public function getFooter(): string
    {
        return $this->footer;
    }

    /**
     * @param string $footer
     * @return SlackMessage
     */
    public function setFooter(string $footer): SlackMessage
    {
        $this->footer = $footer;
        return $this;
    }

    /**
     * @return string
     */
    public function getFooterIcon(): string
    {
        return $this->footerIcon;
    }

    /**
     * @param string $footerIcon
     * @return SlackMessage
     */
    public function setFooterIcon(string $footerIcon): SlackMessage
    {
        $this->footerIcon = $footerIcon;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return SlackMessage
     */
    public function setTitle(string $title): SlackMessage
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitleLink(): string
    {
        return $this->titleLink;
    }

    /**
     * @param string $titleLink
     * @return SlackMessage
     */
    public function setTitleLink(string $titleLink): SlackMessage
    {
        $this->titleLink = $titleLink;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return SlackMessage
     */
    public function setDate(DateTime $date): SlackMessage
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return Field[]
     */
    public function getFields(): array
    {
        return $this->field;
    }

    /**
     * @return array
     */
    public function render() : array
    {
        $attachment = [
                "fallback" => $this->fallback ?? $this->text,
                "color" => $this->color,
                "text" => $this->text,
                "ts" => $this->date->getTimestamp()
            ]
            + $this->appendOptional('pretext', $this->pretext)
            + $this->appendOptional('footer', $this->footer)
            + $this->appendOptional('footer_icon', $this->footerIcon)
            + $this->appendOptional('title', $this->title);

        foreach ($this->field as $field) {
            $attachment['fields'][] = $field->render();
        }
        return $attachment;
    }

    /**
     * @param string $idx
     * @param mixed $value
     * @return array
     */
    private function appendOptional(string $idx, $value) : array
    {
        return empty($value) ? [] : [$idx => $value];
    }
}