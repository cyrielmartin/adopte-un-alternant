<?php
namespace App\Server;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class Chat implements MessageComponentInterface
{
    protected $clients;

    private $users = [];
    private $botName = 'ChatBot';
    private $defaultChannel = 'general';

    public function __construct() {
        $this->clients = new \SplObjectStorage;
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->users[$conn->resourceId] = [
            'connection' => $conn,
            'user' => '',
            'channels' => []
        ];
        $conn->send(sprintf('New connection: Hello #%d', $conn->resourceId));
    }
        

    public function onMessage(ConnectionInterface $conn, $message)
    {
        $messageData = json_decode($message);
        if ($messageData === null) {
            return false;
        }

        $action = $messageData->action ?? 'unknown';
        $channel = $messageData->channel ?? $this->defaultChannel;
        $user = $messageData->user ?? $this->botName;
        $message = $messageData->message ?? '';

        switch ($action) {
            case 'subscribe':
                $this->subscribeToChannel($conn, $channel, $user);
                return true;
            case 'unsubscribe':
                $this->unsubscribeFromChannel($conn, $channel, $user);
                return true;
            case 'message':
                return $this->sendMessageToChannel($conn, $channel, $user, $message);
            default:
                echo sprintf('Action "%s" is not supported yet!', $action);
                break;
        }
        return false;
    }

    public function onClose(ConnectionInterface $conn) {
        // The connection is closed, remove it, as we can no longer send it messages
        //$this->clients->detach($conn);
        unset($this->users[$closedConnection->resourceId]);
        //echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e) {
        echo "An error has occurred: {$e->getMessage()}\n";

        $conn->close();
    }

    private function subscribeToChannel(ConnectionInterface $conn, $channel, $user)
    {
        $this->users[$conn->resourceId]['channels'][$channel] = $channel;
        $this->sendMessageToChannel(
            $conn,
            $channel,
            $this->botName,
            $user.' joined #'.$channel
        );
    }

    private function unsubscribeFromChannel(ConnectionInterface $conn, $channel, $user)
    {
    if (array_key_exists($channel, $this->users[$conn->resourceId]['channels'])) {
        unset($this->users[$conn->resourceId]['channels']);
    }
    $this->sendMessageToChannel(
        $conn,
        $channel,
        $this->botName,
        $user.' left #'.$channel
    );
    }

    private function sendMessageToChannel(ConnectionInterface $conn, $channel, $user, $message)
    {
    if (!isset($this->users[$conn->resourceId]['channels'][$channel])) {
        return false;
    }
   foreach ($this->users as $connectionId => $userConnection) {
        if (array_key_exists($channel, $userConnection['channels'])) {
            $userConnection['connection']->send(json_encode([
                'action' => 'message',
                'channel' => $channel,
                'user' => $user,
                'message' => $message
            ]));
        }
    }
    return true;
    }
}