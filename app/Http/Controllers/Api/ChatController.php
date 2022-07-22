<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SendMessageRequest;
use App\Services\Api\ChatService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    //
    public function sendMessage(SendMessageRequest $request, ChatService $chatService)
    {
        try {
            $previousChat = $chatService->existingChatChecking($request->sender_id, $request->receiver_id);
        } catch (\Exception $e) {
            return makeResponse('error', 'Error in Checking Chat: ' . $e, 500);
        }

        if (!$previousChat) {
            $previousChat = $chatService->create($request);

            if ($previousChat['result'] == 'error') {
                return makeResponse('error', 'Error Came in Saving Chat Message: ' . $previousChat['data'], 500);
            }
        }

        try {
            $saveMessage = $chatService->saveMessage($request, $previousChat['data']);

            if ($saveMessage['result'] == 'error') {
                return makeResponse('error', 'Error Came in Saving Chat Message: ' . $saveMessage['data'], 500);
            }
        } catch (\Exception $e) {
            return makeResponse('error', 'Error in Checking Chat: ' . $e, 500);
        }

        return makeResponse('success', 'Message Send Successfully', 200, $saveMessage['data']);

    }

    public function conversation(Request $request, ChatService $chatService)
    {
        try {
            $previousChat = $chatService->existingChatChecking(Auth::user()->id, $request->other_user_id);
        }
        catch (\Exception $e) {
            return makeResponse('error', 'Error in Checking Chat: ' . $e, 500);
        }

        if (!$previousChat) {
            return makeResponse('error', 'Record Not Found', 404);
        }

        try {
            $previousMessages = $chatService->fetchPreviousChat($previousChat['data'], $request->other_user_id);
        } catch (\Exception $e) {
            return makeResponse('error', 'Error in Fetching Messages: ' . $e, 500);
        }

        if (sizeof($previousMessages) > 0) {
            return makeResponse('success', 'Message Fetch Successfully', 200, $previousMessages);
        } else {
            return makeResponse('error', 'Record Not Found', 404);
        }


    }

    public function chat(Request $request,ChatService $chatService)
    {
        $findUsers =  $chatService->findUserChat(Auth::user()->id);

        if($findUsers)
        {
            return makeResponse('success','List Found',200,$findUsers);
        }
        else{
            return makeResponse('error','Record Not Found',404);

        }
    }


}
