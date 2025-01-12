<?php


namespace App\Services\Socket;

use App\Models\User;
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

        foreach ($io->sockets->adapter->sids[$socket->id] as $key => $item) {
            $socket->leave($key);
        }

        $conversations = $this->chatService->findUserChat($data['user_id']);


        if (sizeof($conversations) > 0) {


            $io->emit($data['user_id'].'-conversationList', [
                'result' => 'success',
                'message' => 'Conversation Found',
                'data' => $conversations
            ]);

//            $socket->broadcast->emit('testing', [
//                'message' => 'done in conversation found',
//                'data' => $conversations
//            ]);


        } else {

            $io->emit($data['user_id'].'-conversationList', [
                'result' => 'success',
                'message' => 'No Conversation Found',
                'data' => []
            ]);

//            $socket->broadcast->emit('testing', [
//                'message' => 'done in no conversation found',
//                'data' => $conversations
//            ]);
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
                $roomPeopleCount =  $roomPeopleCount+1;
            }
        }


        $chatHistory = $this->chatService->fetchPreviousChat($data['conversation_id']);

        if (sizeof($chatHistory) > 0) {
            $socket->emit('chatHistory', [
                'result' => 'success',
                'message' => 'Previous Chat Fetch Successfully',
                'data' => $chatHistory
            ]);
//            $socket->broadcast->emit('testing', [
//                'message' => 'done'
//            ]);
        } else {
            $socket->emit('chatHistory', [
                'result' => 'success',
                'message' => 'Previous Chat Not Found',
                'data' => []
            ]);
//            $socket->broadcast->emit('testing', [
//                'message' => 'done'
//            ]);
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

        if ((isset($previousChat['result']) && $previousChat['result'] == 'error') || !$data['conversation_id']) {

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
                $roomPeopleCount = $roomPeopleCount+1;
            }
        }

        try {

            $saveMessage = $this->chatService->saveMessage($data, $data['conversation_id'], $roomPeopleCount);

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

//        $getReceiver = User::find($data['receiver_id']);
//        $socketID = null;
//        if ($getReceiver) {
//            $socketID = $getReceiver->socket_id;
//            $io->to($socketID)->emit('saveMessage', [
//                'result' => 'success',
//                'message' => 'Message Saved Successfully',
//                'data' => [
//                    $saveMessage['data'],
//                ]
//            ]);
//        }

        $io->to($this->room . $data['conversation_id'])->emit('saveMessage', [
            'result' => 'success',
            'message' => 'Message Saved Successfully',
            'data' => [
                $saveMessage['data'],
            ]

        ]);


//        $io->emit($data['receiver_id'] . '-' . $data['sender_id'] . '-saveMessage', [
//            'result' => 'success',
//            'message' => 'Message Saved Successfully',
//            'data' => [
//                $saveMessage['data'],
//            ]
//        ]);
//
//        $io->emit($data['sender_id'] . '-' . $data['receiver_id'] . '-saveMessage', [
//            'result' => 'success',
//            'message' => 'Message Saved Successfully',
//            'data' => [
//                $saveMessage['data'],
//            ]
//        ]);

        if ($roomPeopleCount != 2) {
//            $data['user_id'] = null;
            $data['user_id'] = $data['receiver_id'];
            $getReceiver = User::find($data['receiver_id']);
            if ($getReceiver) {
                $data['socket_id'] = $getReceiver->socket_id;

                $getReceiverConversation = $this->chatService->findUserChat($data['receiver_id']);

                if (sizeof($getReceiverConversation) > 0) {
                    return $io->emit($data['receiver_id'].'-conversationList', [
                            'result' => 'success',
                            'message' => 'Conversation Found',
                            'data' => $getReceiverConversation
                        ]);
                }

            }

        }
    }

    public function onlineUser($io, $socket, $data)
    {
        if (!isset($data['user_id'])) {
            $socket->emit('onlineUser', [
                'result' => 'error',
                'message' => 'User Id is a required field ',
                'data' => []
            ]);
        }

        $user = User::find($data['user_id']);

        if ($user) {
            $user->is_online = 1;
            $user->socket_id = $socket->id;
            $user->save();
        }


        return $io->to($socket->id)->emit('onlineUser', [
            'result' => 'success',
            'message' => 'User Online Successfully',
            'data' => []
        ]);

//        $findAllChatUsers = $this->chatService->findConversationUser($data['user_id']);
//
//        if (sizeof($findAllChatUsers) > 0) {
//            $socket->to($socket->id)->emit('onlineUser', [
//                'result' => 'onlineUser',
//                'message' => 'User Online Successfully',
//                'data' => []
//            ]);
//
//            foreach ($findAllChatUsers as $chatUser) {
//                $chats = $this->chatService->findUserChat($chatUser->user_id);
//
//                if (sizeof($chats) > 0) {
//                    $socket->emit('conversationList', [
//                        'result' => 'success',
//                        'message' => 'Conversation Found',
//                        'data' => $chats
//                    ]);
//                }
//            }
//        } else {
//            $socket->to($socket->id)->emit('onlineUser', [
//                'result' => 'onlineUser',
//                'message' => 'User Online Successfully',
//                'data' => []
//            ]);
//        }


    }


}
