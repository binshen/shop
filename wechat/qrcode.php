<?php

$access_token = "Cejvd1KFs5wunI-oas8qguWNMbJu_7TEa5o9BVAYzDD77J4vSKb_if8VDetiih8cxtuDqZFyAo3ziAXXqtmTLdAa05J4cwDXKFQnwv8Nq38";

$json_qrcode = '{
	"expire_seconds": 1800,
     "action_name": "QR_SCENE",
     "action_info": {
         "scene": {
             "scene_id": 100000
         }
     }
 }';

$url = "https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token=".$access_token;
$result = https_request($url, $json_qrcode);
$jsoninfo=json_decode($result,true);
print_r($jsoninfo);

echo "<img src='https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$jsoninfo['ticket']."' style='width:100%;'>";

die;







function https_request($url,$data = null){
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
    if (!empty($data)){
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    $output = curl_exec($curl);
    curl_close($curl);
    return $output;
}
