<?php


namespace App\Services\Notifications;


use Carbon\Carbon;

class PushNotificationService 
{


    

    public function execute($data,$token)
    {
        
        $message = $data['title'];
        $date = Carbon::now();
        $header = [
            'Authorization: key= AAAAZX0EosQ:APA91bHDQAcy68t1zBKz7hLT3LkSf15Su_xkudVooIjIRUdE9QiNcRKi260NGIdFzgKW8Eu_Uzma1YeXHVaQ4oljvW2Yoz0ZU4gi22QwNv8IGbNb5WwP4gkxhCzfjIOVXGykdmilGGK7',
            'Content-Type: Application/json'
        ];
        $notification = [
            'title' => 'SLAM',
            'body' =>  $message,
            'icon' => '',
            'image' => '',
            'sound' => 'default',
            'date' => $date->diffForHumans(),
            'content_available' => true,
            "priority" => "high",
            'badge' =>0
        ];
        if (gettype($token) == 'array') {
            $payload = [
                'registration_ids' => $token,
                'data' => (object)$data,
                'notification' => (object)$notification
            ];
        } else {
            
            $payload = [
                'to' => $token,
                'data' => (object)$data,
                'notification' => (object)$notification
            ];
        }
        
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://fcm.googleapis.com/fcm/send",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => json_encode($payload),
            CURLOPT_HTTPHEADER => $header
        ));
        // return true;
        $response = curl_exec($curl);
       
        $d  =[ 'res'=>$response,'data'=>$data];
 
        $err = curl_error($curl);
        curl_close($curl);
        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            return $response;
        }
    }

}
