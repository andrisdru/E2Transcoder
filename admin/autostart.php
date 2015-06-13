<?php
$username = '111'; //Enigma2 transcoder username
$password = '111'; //Enigma2 transcoder password
$controller = 'http://myip/admin/control.php'; //WEB url Path to control.php file
$service = '1:0:1:18BF:E:55:300000:0:0:0:';


//Maybe settings :)

ini_set('session.save_path', '/tmp'); //comment out this if you executing autostart via web server

//------------------ BELLOW THIS LINE DO NOT EDIT ------------

ini_set('session.save_path', '/tmp'); //comment out this if you executing autostart via web server
session_start();
$fields= array(
  
  "action" => "auth",
  "username"=>$username,
  "password"=>$password
  
);
                                                                   
$url=$controller;
$fields_string = '';

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');

$ch = curl_init();
session_write_close();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Ubuntu Chromium/32.0.1700.107 Chrome/32.0.1700.107 Safari/537.36');
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch, CURLOPT_HTTPHEADER, array("X-Requested-With: XMLHttpRequest"));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_COOKIE, 'PHPSESSID=' . session_id()  . '; path=/');
//curl_setopt($ch, CURLOPT_COOKIEFILE, 'cookie.txt'); //probably need to uncomment on some hosts
//curl_setopt($ch, CURLOPT_COOKIEJAR, 'cookie.txt'); //probably need to uncomment on some hosts

$result = curl_exec($ch);

echo $result;
$fields_string = '';
$fields= array(
  "service" => $service,
);       
                                                           
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value; }
rtrim($fields_string, '&');
curl_setopt($ch,CURLOPT_POST, count($fields));
curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
$result = curl_exec($ch);
echo $result;
curl_close($ch);
?>