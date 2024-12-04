<?php

namespace Application;

use Telegram\Bot\Objects\Message;

class MessageProcessor
{
    public function __construct(private PrivateMessageProcessor $privateMessageProcessor)
    {
    }

    public function process(Message $message)
    {
        switch ($message->chat->type) {
            case 'private':
                $this->privateMessageProcessor->process($message);
                break;
            case 'group':
            case 'supergroup':
//                $this->groupMessageProcessor->processMessage($message);
                break;
        }
    }
}