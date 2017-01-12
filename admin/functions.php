<?php



$db = new SQLite3($conf["database"]); //opening database


//Cleaning for html 
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}



//Return current channel
function current_channel(){
global $conf;

 if ( $conf["callreceiver"] == 0) {
 	return 0;}
 else {
	
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Basic " . base64_encode($conf["db_username"].":".$conf["db_password"])                
  )
);

$context = stream_context_create($opts);


// Open the file using the HTTP headers set above
$bouquetsfile = file_get_contents("http://".$conf["db_ip"].":".$conf["db_web_port"]."/web/subservices", false, $context);


$bouquetsxml = new SimpleXMLElement($bouquetsfile);


$xmlarray = (array)$bouquetsxml;

return $xmlarray;

}}


function cleanref($service){
global $conf;	
	
	$serviceref = str_replace( "http://".$conf["db_ip"].":".$conf["db_stream_port"]."/", '', $service);
	
	return $serviceref;
	
}


?>