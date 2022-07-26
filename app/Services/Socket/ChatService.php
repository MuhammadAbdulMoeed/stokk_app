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
                'data' => null
            ]);
        }

        $conversations =  $this->chatService->findUserChat($data['user_id']);

        if(sizeof($conversations) > 0)
        {
            return $socket->emit('conversationList',[
                'result'=>'success',
                'message'=>'Conversation Found',
                'data' => $conversations
            ]);
        }
        else{
            return $socket->to($socket->user_id)->emit('conversationList',[
                'result'=>'error',
                'message'=>'No Conversation Found',
                'data' => null
            ]);
        }
    }

    public function sendMessage($io, $socket, $data)
    {
        if (!isset($data['sender_id'])) {
            $socket->emit('create_chat_response', [
                'result' => 'error',
                'message' => 'Sender ID is a required field ',
                'data' => null
            ]);
        }

        if (!isset($data['receiver_id'])) {
            $socket->emit($data['sender_id'] . '-create_chat_response', [
                'result' => 'error',
                'message' => 'Receiver ID is a required field ',
                'data' => null
            ]);
        }

//        if(!isset($data['room_id'])){
//            $socket->emit($data['sender_id'].'-create_chat_response', [
//                'result' => 'error',
//                'message' => 'Receiver ID is a required field ',
//                'data' => null
//            ]);
//        }

        try {
            $previousChat = $this->chatService->existingChatChecking($data->sender_id, $data->receiver_id);
        } catch (\Exception $e) {
            $socket->emit('create_chat_response', [
                'result' => 'error',
                'message' => 'Error in Fetching Previous Conversation',
                'data' => null
            ]);
        }

        if (!$previousChat) {
            $previousChat = $this->chatService->create($data);

            if ($previousChat['result'] == 'error') {
                return makeResponse('error', 'Error Came in Saving Chat Message: ' . $previousChat['data'], 500);
            }
        }

        try {
            $saveMessage = $this->chatService->saveMessage($data, $previousChat['data']);

            if ($saveMessage['result'] == 'error') {
                return makeResponse('error', 'Error Came in Saving Chat Message: ' . $saveMessage['data'], 500);
            }
        } catch (\Exception $e) {
            return makeResponse('error', 'Error in Checking Chat: ' . $e, 500);
        }


        return makeResponse('success', 'Message Send Successfully', 200, $saveMessage['data']);

    }

    public function chatHistory($io,$socket,$data)
    {
        if (!isset($data['user_id'])) {
            $socket->emit('chatHistory', [
                'result' => 'error',
                'message' => 'User ID is a required field ',
                'data' => null
            ]);
        }

        if(isset($data['conversation_id']))
        {
//            dd(io.in('YOUR_ROOM').engine.clientsCount );
            $socket->join($this->room.$data['conversation_id']);
            $socket->join($this->room.$data['conversation_id']);
        }

        foreach($io->sockets->adapter->rooms as $key => $item)
        {
            dd(sizeof($io->sockets->adapter->rooms));
        }



        $socket->emit('chatHistory', [
            'result' => 'success',
            'message' => 'Connected TO Room',
            'data' => null
        ]);



//        return $this->chatService->fetchPreviousChat();


    }


}
