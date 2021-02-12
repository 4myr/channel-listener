<?php
if (!file_exists('madeline.php')) {
    copy('https://phar.madelineproto.xyz/madeline.php', 'madeline.php');
}

include 'madeline.php';
require_once 'config.php';

use danog\MadelineProto\EventHandler;
use danog\MadelineProto\Tools;
use danog\MadelineProto\API;
use danog\MadelineProto\Logger;
use danog\MadelineProto\RPCErrorException;

/**
 * Event handler class.
 */
class MainEventHandler extends EventHandler
{
    /**
     * @var int|string Username or ID of bot admin
     */
    const ADMIN = SUDO; // Change this

    /**
     * Get peer(s) where to report errors
     *
     * @return int|string|array
     */
    public function getReportPeers()
    {
        return [self::ADMIN];
    }

    /**
      * Called on startup, can contain async calls for initialization of the bot
      *
      * @return void
      */
    public function onStart()
    {
        //
    }

    /**
     * Handle updates from supergroups and channels
     *
     * @param array $update Update
     * 
     * @return void
     */
    public function onUpdateNewChannelMessage(array $update): \Generator
    {
        return $this->onUpdateNewMessage($update);
    }

    /**
     * Handle updates from users.
     *
     * @param array $update Update
     *
     * @return \Generator
     */
    public function onUpdateNewMessage(array $update): \Generator
    {
        if ($update['message']['_'] === 'messageEmpty' || $update['message']['out'] ?? false) {
            return;
        }
        $res = \json_encode($update);
        try {
            $message_id = $update['message']['id'];
            
            $to_id = $update['message']['to_id']['channel_id'] ?? null;
            $from_id = $update['message']['from_id'] ?? null;
            $message = $update['message']['message'] ?? null;
                
            if ($to_id) {
                if (in_array($to_id, SOURCE_CHANNELS)) {
                    // If message is set means message is only text and not media!
                    if ($message) {
                        yield $this->messages->sendMessage(['peer' => TARGET_CHANNEL, 'message' => $message]);
                    }
                }
            }
        } catch (RPCErrorException $e) {
            //
        } catch (Exception $e) {
            //
        }
    }   
}
$settings = [
    'serialization' => [
        'serialization_interval' => 30,
    ],
];

$MadelineProto = new API('bot.madeline', $settings);
$MadelineProto->startAndLoop(MainEventHandler::class);
