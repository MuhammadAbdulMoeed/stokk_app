<?php


namespace App\Services\Api;


use App\Models\Chat;
use App\Models\ChatMessage;
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


    public function existingChatChecking($sender_id, $receiver_id)
    {
        $checkForPreviousChat = Chat::where('user_1', $sender_id)
            ->where('user_2', $receiver_id)->first();

        if (!$checkForPreviousChat) {
            $checkForPreviousChat = Chat::where('user_1', $receiver_id)
                ->where('user_2', $sender_id)->first();
        }

        if ($checkForPreviousChat) {
            $response = ['result' => 'success', 'data' => $checkForPreviousChat->id];

            return $response;

        } else {
            return false;
        }


    }

    public function fetchPreviousChat($chatId, $otherUserId)
    {
        $chatMessages = ChatMessage::with(['sender', 'receiver'])
            ->where('chat_id', $chatId)
            ->where(function ($query) {
                $query->where('sender_id', Auth::user()->id)->orWhere('receiver_id', Auth::user()->id);
            })
            ->where(function ($query) use ($otherUserId) {
                $query->where('sender_id', $otherUserId)->orWhere('receiver_id', $otherUserId);
            })
            ->get();


        $messages = array();
        if (sizeof($chatMessages) > 0) {
            foreach ($chatMessages as $chatMessage) {
//                if(Auth::user()->id == $chatMessage->sender_id)
//                {
                $messages[] = [
                    'id' => $chatMessage->id,
                    'chat_id' => $chatMessage->chat_id,
                    'sender_id' => $chatMessage->sender_id, 'message' => $chatMessage->message,
                    'receiver_id' => $chatMessage->receiver_id, 'sender_name' => $chatMessage->sender->username,
                    'sender_profile_image' => $chatMessage->sender->profile_image
                ];
//                }
//                else{
//                    $messages[] = [
//                        'id' => $chatMessage->id,
//                        'chat_id'=>$chatMessage->chat_id,
//                        'sender_id'=>$chatMessage->sender_id,'message'=>$chatMessage->message,
//                        'receiver_id'=>$chatMessage->receiver_id,'sender_name'=>$chatMessage->sender->username,
//                        'sender_profile_image'=>$chatMessage->sender->profile_image
//                    ];
//                }

            }

            return $messages;
        } else {
            return $messages;
        }
    }

    public function create($request)
    {
        DB::beginTransaction();
        try {
            $createChat = Chat::create(['user_1' => $request->sender_id,
                'user_2' => $request->receiver_id]);

            DB::commit();
            $response = ['result' => 'success', 'data' => $createChat->id];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['result' => 'success', 'data' => $e];
        }

        return $response;

    }

    public function saveMessage($request, $chatId)
    {
        DB::beginTransaction();
        try {
            $chatMessage = ChatMessage::create([
                'chat_id' => $chatId, 'sender_id' => $request->sender_id,
                'receiver_id' => $request->receiver_id, 'message' => $request->message
            ]);

            DB::commit();
            $response = ['result' => 'success', 'data' => $chatMessage];
        } catch (\Exception $e) {
            DB::rollBack();
            $response = ['result' => 'error', 'data' => $e];
        }

        return $response;

    }

    public function findUserChat($userId)
    {
        $userChats = Chat::with(['firstUser', 'secondUser'])->where(function ($query) {
            $query->where('user_1', Auth::user()->id)->orWhere('user_2', Auth::user()->id);
        })
            ->get();

        $chats = array();

        foreach ($userChats as $chat) {
            if ($chat->user_1 == Auth::user()->id) {
                $chats[] = ['username' => $chat->secondUser->username,
                    'socket_id' => $chat->secondUser->socket_id,'user_id'=>$chat->secondUser->id,
                    'profile_image' => $chat->profile_image];
            } elseif ($chat->user_2 == Auth::user()->id) {
                $chats[] = ['username' => $chat->firstUser->username,
                    'socket_id' => $chat->firstUser->socket_id,'user_id'=>$chat->firstUser->id,
                    'profile_image' => $chat->firstUser->profile_image];
            }
        }

        return $chats;
    }
}
