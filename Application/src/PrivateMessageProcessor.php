<?php

namespace Application;
use Telegram\Bot\Api;
use Telegram\Bot\FileUpload\InputFile;
use Telegram\Bot\Objects\Message;
class PrivateMessageProcessor
{
    public function __construct(
        private Api $telegram,
        private Downloader $downloader,
    )
    {
    }

    public function process(Message $message)
    {
        if (!$message->chat->id == ConfigProvider::getAdminId()) {
            return;
        }
        $messageText = $message->text;
        if ($this->hasUrl($messageText)) {
            try {
                $filename = $this->downloader->download($messageText);
                $this->telegram->sendVideo(
                    [
                        'chat_id' => ConfigProvider::getDestinationChannel(),
                        'video' => InputFile::createFromContents(file_get_contents($filename), 'video.mp4'),
                    ]
                );
                unlink($filename);
            } catch (\Exception $exception) {}
        } else {

        }
    }

    private function hasUrl(string $string): bool
    {
        $url = parse_url($string);
        return isset($url['scheme'], $url['host'], $url['path']);
    }
}