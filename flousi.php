<?php
$amount =$_GET['amount'];
$studentID =$_GET['studentID'];
$coursepin =$_GET['coursepin'];
$amount=$amount*1000;
$amount=strval($amount);


$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://developers.flouci.com/api/generate_payment',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "app_token": "a511bfe8-bf0b-4435-bb2d-a4b93a88b128",
    "app_secret": "ffa009bd-1c21-4104-a715-a8e1f9f9b3cd",
    "accept_card": "true",
    "amount": "'.$amount.'",
    "success_link": "http://localhost/kes/paiemenet.php?amount='.$amount.'&&studentID='.$studentID.'&&coursepin='.$coursepin.'",
    "fail_link": "http://localhost/kes/paiemenet.php?amount='.$amount.'&&studentID='.$studentID.'&&coursepin='.$coursepin.'",
    "session_timeout_secs": 1200,
    "developer_tracking_id": "225f6ba0-b78e-4c88-9e7b-a9b203ab90df"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;
$data = json_decode($response, true); // true to convert it to an associative array
$link= $data['result']['link'];
header( 'Location: '. $link) ;
?>