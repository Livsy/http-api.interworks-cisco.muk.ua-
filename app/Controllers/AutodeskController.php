<?
namespace App\Controllers;
//use App\Controllers\BaseController;

/*
 * https://partner.developer-stg.autodesk.com/sample-code/php
 * login:   adsk@muk.ua
 * pass:    AutodeskMUK2021
 *
 * */

class AutodeskController extends BaseController
{
    function __construct()
    {
//        parent::__construct();

    }


    function oauth()
    {
        // --------------------------------------
        // 1.1. Get Your credentials from developer portal

        $client_id = "EJreRaSI06KfA9wBbzCRzHfCldk1vGkS";
        $client_secret = "xMQ7FA4uGQmFzMsG";
        $callback_url = "www.callback.autodesk.com";
//        $partner_csn = "Your csn";

        // --------------------------------------
        // 1.2. Create Signature

        $time_stamp = strtotime("now");
        $base_str = $callback_url.$client_id.$time_stamp;
        $hmacsha256 = hash_hmac('sha256', $base_str, $client_secret, true);
        $signature = base64_encode($hmacsha256);

        // --------------------------------------
        // 1.3. Create Authorization

        $base_64_message = $client_id.":".$client_secret;
        $base_64_encoded = base64_encode($base_64_message);

        // --------------------------------------
        // 1.4. Call Authentication API to get access token


        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://enterprise-api-stg.autodesk.com/v2/oauth/generateaccesstoken?grant_type=client_credentials",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => "grant_type=client_credentials",
            CURLOPT_HTTPHEADER => array(
                "Authorization: Basic ".$base_64_encoded,
                "cache-control: no-cache",
                "signature: ".$signature,
                "timestamp: ".$time_stamp
            ),

//            CURLOPT_SSL_VERIFYPEER => false,
//            CURLOPT_SSL_VERIFYHOST => false,
//            CURLOPT_SSLVERSION => 3,
        ));

        $response = curl_exec($ch);

        $info = curl_getinfo($ch);
//        $info = '';
//        if (!curl_errno($ch)) {
//            $info = curl_getinfo($ch);
//            echo 'Прошло ', $info['total_time'], ' секунд во время запроса к ', $info['url'], "\n";
//        }
//var_dump($info);
        curl_close($ch);


        echo '<br>------ $response  -------<br>';
        echo $response;
//        echo '<br>------ $err -------<br>';
//        echo $err;
        echo '<br>------ $info -------<br>';
        echo '<pre>'.print_r($info, true).'</pre>';;
        exit;


        if ($err)
        {
            echo "cURL Error #:" . $err;
        }
        else {
            $decoded_response = json_decode($response, true);
            $access_token = $decoded_response['access_token'];
            return $access_token;
        }

        //$access_token = getToken($client_id,$client_secret,$callback_url);

        echo $access_token;
    }

}


