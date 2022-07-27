<?php


namespace App\Services\Socket;

use App\Services\Api\ChatService as PassengerChat;

class ChatService
{
    public $chatService;
    public $room = 'privateRoom-';


    public function __construct(PassengerChat $chatService)
    {
        $this->chatService = $chatService;
    }

    public function conversationList($io, $socket, $data)
    {

        if (!isset($data['user_id'])) {
            $socket->emit('conversationList', [
                'result' => 'error',
                'message' => 'User ID is a required field ',
                'data' => []
            ]);
        }

        $conversations = $this->chatService->findUserChat($data['user_id']);

        if (sizeof($conversations) > 0) {
            return $socket->emit('conversationList', [
                'result' => 'success',
                'message' => 'Conversation Found',
                'data' => $conversations
            ]);
        } else {
            return $socket->emit('conversationList', [
                'result' => 'success',
                'message' => 'No Conversation Found',
                'data' => []
            ]);
        }
    }

    public function chatHistory($io, $socket, $data)
    {
        if (!isset($data['user_id'])) {
            $socket->emit('chatHistory', [
                'result' => 'error',
                'message' => 'User ID is a required field ',
                'data' => []
            ]);
        }

        if (isset($data['conversation_id'])) {
            //get all room this socket is connected to
            foreach ($io->sockets->adapter->sids[$socket->id] as $key => $item) {
                $socket->leave($key);
            }

            $socket->join($this->room . $data['conversation_id']);
        }

        //get total people in room
        $roomPeopleCount = 0;
        foreach ($io->sockets->adapter->rooms as $key => $item) {
            if ($key == $this->room . $data['conversation_id']) {
                $roomPeopleCount++;
            }
        }

        $chatHistory = $this->chatService->fetchPreviousChat($data['conversation_id']);

        if (sizeof($chatHistory) > 0) {
            $socket->emit('chatHistory', [
                'result' => 'success',
                'message' => 'Previous Chat Fetch Successfully',
                'data' => $chatHistory
            ]);
        } else {
            $socket->emit('chatHistory', [
                'result' => 'success',
                'message' => 'Previous Chat Not Found',
                'data' => []
            ]);
        }


    }

    public function sendMessage($io, $socket, $data)
    {
        if (!isset($data['sender_id'])) {
            $socket->emit('saveMessage', [
                'result' => 'error',
                'message' => 'Sender ID is a required field ',
                'data' => []
            ]);
        }

        if (!isset($data['receiver_id'])) {
            $socket->emit('saveMessage', [
                'result' => 'error',
                'message' => 'Receiver ID is a required field ',
                'data' => []
            ]);
        }

        if ($data['conversation_id']) {
            try {
                $previousChat = $this->chatService->existingChatChecking($data['sender_id'], $data['receiver_id'], $data['conversation_id']);

                if ($previousChat['result'] == 'not_match_error') {
                    $socket->emit('saveMessage', [
                        'result' => 'error',
                        'message' => $previousChat['message'],
                        'data' => []
                    ]);
                }
            } catch (\Exception $e) {
                $socket->emit('saveMessage', [
                    'result' => 'error',
                    'message' => 'Error in Fetching Previous Conversation: ' . $e,
                    'data' => []
                ]);
            }

        }

        if ((isset($previousChat['result']) &&  $previousChat['result']== 'error') || !$data['conversation_id']) {

            $previousChat = $this->chatService->createConversation($data);

            $data['conversation_id'] = $previousChat['data'];

            if ($previousChat['result'] == 'error') {
                $socket->emit('saveMessage', [
                    'result' => 'error',
                    'message' => 'Error in Creating Conversation: ' . $previousChat['data'],
                    'data' => []
                ]);
            }
        }

        //get all room this socket is connected to
        foreach ($io->sockets->adapter->sids[$socket->id] as $key => $item) {
            $socket->leave($key);
        }

        //join room
        $socket->join($this->room . $data['conversation_id']);

        //get total people in room
        $roomPeopleCount = 0;
        foreach ($io->sockets->adapter->rooms as $key => $item) {
            if ($key == $this->room . $data['conversation_id']) {
                $roomPeopleCount++;
            }
        }


        try {

            $saveMessage = $this->chatService->saveMessage($data, $data['conversation_id'],$roomPeopleCount);

            if ($saveMessage['result'] == 'error') {
                $socket->emit('saveMessage', [
                    'result' => 'error',
                    'message' => 'Error in Saving Chat Message: ' . $saveMessage['data'],
                    'data' => []
                ]);
            }
        }
        catch (\Exception $e) {
            $socket->emit('saveMessage', [
                'result' => 'error',
                'message' => 'Error in Saving Chat Message: ' . $e,
                'data' => []
            ]);
        }


        $socket->to($this->room.$data['conversation_id'])->emit('saveMessage', [
            'result' => 'success',
            'message' => 'Message Saved Successfully',
            'data' => [
                $saveMessage['data'],
            ]
        ]);
    }


}
