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
            $response = ['result' => 'success', 'data' => $checkForPreviousChat->id];

            return $response;
        }


    }

    public function fetchPreviousChat($chatId)
    {
        $chatMessages = ChatMessage::with(['sender', 'receiver'])
            ->where('chat_id', $chatId)
            ->get();


        $messages = array();
        if (sizeof($chatMessages) > 0) {
            foreach ($chatMessages as $chatMessage) {

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
                    'created_ago' => Carbon::parse($chatMessage->created_at)->diffForHumans(),
                    'created_at' =>  Carbon::parse($chatMessage->created_at)->format('d-m-Y')
//                    'receiver_name' => $chatMessage->receiver->user_name,
                ];

            }

            return $messages;
        }
        else {
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

            $senderResponseArray = [
                'first_name' => $chatMessage->sender->first_name,
                'last_name' => $chatMessage->sender->last_name,
                'user_name' => $chatMessage->sender->user_name,
                'profile_image' => $chatMessage->sender->profile_image,
                'message' => $chatMessage->message,
                'chat_id' => $chatId,
                'receiver_id' => $request->receiver_id,
                'created_at' => Carbon::parse($chatMessage->created_at)->format('H:i:s'),
                'created_ago' => Carbon::parse($chatMessage->created_at)->diffForHumans()
            ];

            $receiverResponseArray = [
                'first_name' => $chatMessage->receiver->first_name,
                'last_name' => $chatMessage->receiver->last_name,
                'user_name' => $chatMessage->receiver->user_name,
                'profile_image' => $chatMessage->receiver->profile_image,
                'message' => $chatMessage->message,
                'chat_id' => $chatId,
                'sender_id' => $request->sender_id,
                'created_at' => Carbon::parse($chatMessage->created_at)->format('H:i:s'),
                'created_ago' => Carbon::parse($chatMessage->created_at)->diffForHumans()
            ];

            DB::commit();
            $response = ['result' => 'success', 'data' => $chatMessage, 'senderResponseArray' => $senderResponseArray, 'receiverResponseArray' => $receiverResponseArray];
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
                $chats[] = ['first_name' => $chat->secondUser->first_name,
                    'last_name' => $chat->secondUser->last_name,
                    'user_id' => $chat->secondUser->id, 'conversation_id' => $chat->id,
                    'profile_image' => $chat->profile_image];
            } elseif ($chat->secondUser->id == $user_id) {
                $chats[] = [
                    'first_name' => $chat->firstUser->first_name,
                    'last_name' => $chat->firstUser->last_name,
                    'user_id' => $chat->firstUser->id, 'conversation_id' => $chat->id,
                    'profile_image' => $chat->firstUser->profile_image];
            }


        }


        return $chats;
    }
}
