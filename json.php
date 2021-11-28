<?php
// 制定允许其他域名访问
header("Access-Control-Allow-Origin:*");
// 响应类型
header('Access-Control-Allow-Methods:POST');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with, content-type');

$curl = curl_init();
$jsonurl = $_GET["url"];
curl_setopt_array($curl, array(
  CURLOPT_URL => $jsonurl,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "cache-control: no-cache"
  ),
));
 
$response = curl_exec($curl);
$err = curl_error($curl);
 
curl_close($curl);
 
// $response = json_decode($response, true); //because of true, it's in an array
// echo 'Online: '. $response['players']['online'];
echo $response;
 
?>
