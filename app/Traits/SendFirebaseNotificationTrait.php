<?php


namespace App\Traits;


trait SendFirebaseNotificationTrait
{

    public function orderNotification($title,$message,$fcmToken)
    {
        $data =  array();
        $data ['title'] = $title;
        $data['body'] = $message;
        $data['data'] = null;

        $this->sendPushNotification($fcmToken,$data);

        return true;

    }


    public function sendPushNotification($fcm, $dataBody)
    {

        $client = new \GuzzleHttp\Client(['verify' => false]);
        $fireBaseKey = env('FCM_SERVER_KEY');

        $request = $client->post(
            'https://fcm.googleapis.com/fcm/send',
            [
                'headers' => [
                    'Authorization' => 'key=' . $fireBaseKey,
                    'Content-Type' => 'application/json'
                ],
                'body' => json_encode([
                    "to" => $fcm,
                    "priority" => "high",
                    "content_available" => true,
                    "mutable_content" => true,
                    "time_to_live" => 0,
//                    "notification" => $dataNoti,
                    "data" => $dataBody,
                    "notification" => $dataBody,
                ])
            ]
        );

        $response = $request->getBody();
        $response = json_decode($response);


        if ($response->success > 0) {
            return true;
        } else {
            return false;
        }

    }
}
