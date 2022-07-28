<?php


namespace App\Services\Api;


use App\Models\Chat;
use App\Models\ChatMessage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ChatService
{
    public function chat($request)
    {
        try {
            $previousMessages = array();

            $checkForPreviousChat = Chat::where('user_1', Auth::user()->id)
                ->where('user_2', $request->other_user_id)->first();

            if (!$checkForPreviousChat) {
                $checkForPreviousChat = Chat::where('user_1', $request->other_user_id)
                    ->where('user_2', Auth::user()->id)->first();
            }


            if ($checkForPreviousChat) {
                $previousMessages = $this->fetchPreviousChat($checkForPreviousChat->id, $request->other_user_id);
            }

            if (sizeof($previousMessages) > 0) {
                return makeResponse('success', 'Message Fetch Successfully', 200, $previousMessages);
            } else {
                return makeResponse('error', 'No Record Found', 404);
            }
        } catch (\Exception $e) {
            return makeResponse('error', 'Some Error Occur: ' . $e, 500);
        }

    }

    public function existingChatChecking($sender_id, $receiver_id, $conversation_id)
    {
        $checkForPreviousChat = Chat::where('user_1', $sender_id)
            ->where('user_2', $receiver_id)->first();

        if (!$checkForPreviousChat) {
            $checkForPreviousChat = Chat::where('user_1', $receiver_id)
                ->where('user_2', $sender_id)->first();
        }

        if ($checkForPreviousChat) {
            if ($checkForPreviousChat->id != $conversation_id) {
                $response = ['result' => 'not_match_error', 'message' => 'Conversation ID Not Match'];

                return $response;
            }
            $response = ['result' => 'success', 'data' => $checkForPreviousChat->id];

            return $response;
        } else {
            $response = ['result' => 'error', 'data' => 'No Record Found'];

            return $response;
        }

    }

    public function fetchPreviousChat($chatId = null)
    {

        $messages = array();

        if ($chatId) {
            $chatMessages = ChatMessage::with(['sender', 'receiver'])
                ->where('chat_id', $chatId)
                ->get();


            if (sizeof($chatMessages) > 0) {
                foreach ($chatMessages as $chatMessage) {
                    $chatMessage->update(['is_read' => 1]);

                    $messages[] = [
                        'id' => $chatMessage->id,
                        'conversation_id' => $chatMessage->chat_id,
                        'sender_id' => $chatMessage->sender_id, 'message' => $chatMessage->message,
                        'receiver_id' => $chatMessage->receiver_id,
//                    'sender_name' => $chatMessage->sender->user_name,
                        'sender_first_name' => $chatMessage->sender->first_name,
                        'sender_last_name' => $chatMessage->sender->last_name,
                        'sender_profile_image' => $chatMessage->sender->profile_image,
                        'receiver_profile_image' => $chatMessage->receiver->profile_image,
                        'receiver_first_name' => $chatMessage->receiver->first_name,
                        'receiver_last_name' => $chatMessage->receiver->last_name,
                        'is_read' => $chatMessage->is_read,
                        'created_ago' => Carbon::parse($chatMessage->created_at)->diffForHumans(),
                        'created_at' => Carbon::parse($chatMessage->created_at)->format('d-m-Y'),
                        'receiver_time' => Carbon::parse($chatMessage->created_at)->tz($chatMessage->receiver->timezone)->format('h:i A'),
                        'sender_time' => Carbon::parse($chatMessage->created_at)->tz($chatMessage->sender->timezone)->format('h:i A')

//                    'receiver_name' => $chatMessage->receiver->user_name,
                    ];

                }

                return $messages;
            } else {
                return $messages;
            }
        } else {
            return $messages;
        }

    }

    public function createConversation($data)
    {
        DB::beginTransaction();
        try {
            $createChat = Chat::create(['user_1' => $data['sender_id'],
                'user_2' => $data['receiver_id']
            ]);

            DB::commit();
            $response = ['result' => 'success', 'data' => $createChat->id];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['result' => 'success', 'data' => $e];
        }

        return $response;

    }

    public function saveMessage($data, $chatId, $roomPeopleCount)
    {
        DB::beginTransaction();
        try {
            if ($roomPeopleCount == 2) {
                $chatMessage = ChatMessage::create([
                    'chat_id' => $chatId, 'sender_id' => $data['sender_id'],
                    'receiver_id' => $data['receiver_id'], 'message' => $data['message'],
                    'is_read' => 1
                ]);
            } else {
                $chatMessage = ChatMessage::create([
                    'chat_id' => $chatId, 'sender_id' => $data['sender_id'],
                    'receiver_id' => $data['receiver_id'], 'message' => $data['message'],
                    'is_read' => 0
                ]);
            }


            $responseMessage = [
                'id' => $chatMessage->id,
                'conversation_id' => $chatMessage->chat_id,
                'sender_id' => $chatMessage->sender_id, 'message' => $chatMessage->message,
                'receiver_id' => $chatMessage->receiver_id,
//                    'sender_name' => $chatMessage->sender->user_name,
                'sender_first_name' => $chatMessage->sender->first_name,
                'sender_last_name' => $chatMessage->sender->last_name,
                'sender_profile_image' => $chatMessage->sender->profile_image,
                'receiver_profile_image' => $chatMessage->receiver->profile_image,
                'receiver_first_name' => $chatMessage->receiver->first_name,
                'receiver_last_name' => $chatMessage->receiver->last_name,
                'is_read' => $chatMessage->is_read,
                'created_ago' => Carbon::parse($chatMessage->created_at)->diffForHumans(),
                'created_at' => Carbon::parse($chatMessage->created_at)->format('d-m-Y'),
                'receiver_time' => Carbon::parse($chatMessage->created_at)->tz($chatMessage->receiver->timezone)->format('h:i A'),
                'sender_time' => Carbon::parse($chatMessage->created_at)->tz($chatMessage->sender->timezone)->format('h:i A')
            ];

            DB::commit();
            $response = ['result' => 'success', 'data' => $responseMessage];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['result' => 'error', 'data' => $e];
        }

        return $response;

    }

    public function findUserChat($user_id)
    {
        $userChats = Chat::with(['firstUser', 'secondUser'])->where(function ($query) use ($user_id) {
            $query->where('user_1', $user_id)->orWhere('user_2', $user_id);
        })
            ->get();


        $chats = array();


        foreach ($userChats as $chat) {
            if ($chat->firstUser->id == $user_id) {
                $fetchLastMessageRecord = $this->lastMessageTime($chat->id,$chat->firstUser->timezone);

                $chats[] = ['first_name' => $chat->secondUser->first_name,
                    'last_name' => $chat->secondUser->last_name,
                    'user_id' => $chat->secondUser->id, 'conversation_id' => $chat->id,
                    'last_message_time' => isset($fetchLastMessageRecord['lastMessageTime']) ? $fetchLastMessageRecord['lastMessageTime']:null,
                    'last_message' => isset($fetchLastMessageRecord['lastMessage']) ? $fetchLastMessageRecord['lastMessage']:null,
                    'message_send_time' => isset($fetchLastMessageRecord['messageSendTime']) ? $fetchLastMessageRecord['messageSendTime']:null,
                    'unread_message' => $this->getUnreadMessageCount($chat->id, $chat->firstUser->id),
                    'profile_image' => $chat->secondUser->profile_image];
            } elseif ($chat->secondUser->id == $user_id) {
                $fetchLastMessageRecord = $this->lastMessageTime($chat->id,$chat->secondUser->timezone);

                $chats[] = [
                    'first_name' => $chat->firstUser->first_name,
                    'last_name' => $chat->firstUser->last_name,
                    'user_id' => $chat->firstUser->id, 'conversation_id' => $chat->id,
                    'last_message_time' => isset($fetchLastMessageRecord['lastMessageTime']) ? $fetchLastMessageRecord['lastMessageTime']:null,
                    'last_message' => isset($fetchLastMessageRecord['lastMessage']) ? $fetchLastMessageRecord['lastMessage']:null,
                    'message_send_time' => isset($fetchLastMessageRecord['messageSendTime']) ? $fetchLastMessageRecord['messageSendTime']:null,

                    'unread_message' => $this->getUnreadMessageCount($chat->id, $chat->secondUser->id),
                    'profile_image' => $chat->firstUser->profile_image];
            }
        }

        return $chats;
    }

    public function getUnreadMessageCount($conversation_id, $user_id)
    {
        $data = ChatMessage::where('chat_id', $conversation_id)->where('receiver_id', $user_id)
            ->where('is_read', 0)->count();

        return $data;
    }

    public function findConversationUser($data)
    {
        $userChats = Chat::with(['firstUser', 'secondUser'])->where(function ($query) use ($data) {
            $query->where('user_1', $data['user_id'])->orWhere('user_2', $data['user_id']);
        })->get();


        $users = array();


        foreach ($userChats as $chat) {
            if ($chat->firstUser->id == $data['user_id']) {
                if ($chat->secondUser->is_online == 1 && $chat->secondUser->socket_id != null) {
                    $users[] = ['user_id' => $chat->secondUser->id,
                        'socket_id' => $chat->secondUser->socket_id];
                }

            } elseif ($chat->secondUser->id == $data['user_id']) {
                if ($chat->firstUser->is_online == 1 && $chat->firstUser->socket_id != null) {
                    $users[] = ['user_id' => $chat->firstUser->id,
                        'socket_id' => $chat->firstUser->socket_id];
                }
            }
        }
        return $users;
    }

    public function lastMessageTime($conversation_id,$timeZone)
    {
        $userChats = ChatMessage::where('chat_id',$conversation_id)
            ->orderBy('id','desc')->first();

        $response =  array();

        if($userChats)
        {
            $response = [
                'lastMessageTime' => Carbon::parse($userChats->created_at)->tz($timeZone)->format('h:i A'),
                'lastMessage' => $userChats->message,
                'messageSendTime' => strtotime($userChats->created_at)
            ];

            return $response;
        }
        else{
            return $response;
        }

    }
}
