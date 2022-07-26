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
            return $socket->emit('conversationList',[
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
            //get all room this socket is connected to
            foreach($io->sockets->adapter->sids[$socket->id] as $key =>$item)
            {
                $socket->leave($key);
            }

            $socket->join($this->room.$data['conversation_id']);
        }

        //get total people in room
        $roomPeopleCount = 0;
        foreach($io->sockets->adapter->rooms as $key => $item)
        {
            if($key == $this->room.$data['conversation_id'])
            {
                $roomPeopleCount++;
            }
        }

        $chatHistory = $this->chatService->fetchPreviousChat($data['conversation_id']);

        if(sizeof($chatHistory) > 0)
        {
            $socket->emit('chatHistory', [
                'result' => 'success',
                'message' => 'Chat Fetch Successfully',
                'data' => $chatHistory
            ]);
        }
        else{
            $socket->emit('chatHistory', [
                'result' => 'error',
                'message' => 'Chat Not Found',
                'data' => null
            ]);
        }




//        return $this->chatService->fetchPreviousChat();


    }


}
