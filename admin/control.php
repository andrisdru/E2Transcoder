<?php



require("config.php");
if (strncasecmp(PHP_OS,'WIN',3)==0) {
include_once("wrun.php");
}

else {
include_once("lrun.php");
}
require("functions.php");

$db = new SQLite3($conf["database"]); //opening database

session_start();

//START TRANSCODE ACTION

if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["service"]) && !empty($_POST["service"]) && !empty($_POST["action"]) && $_POST["action"]=="start" ) { //Checks if action value exists

      $result = $db->query("SELECT * FROM settings LIMIT 1");
      $row = $result->fetchArray();  

      $ref = $_POST["service"];
      error_log("debug1:".$ref);
      $response = start($ref, $row["crf"], $row["audio"], $row["width"]);
    

    echo json_encode(array(
    "status" => $response["status"],
    "service_name" => $response["service_name"],
    
));    
    
  }
}

//STOP TRANSCODE ACTION

if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="stop" ) { //Checks if action value exists

    $response = stop();
   
    //cleanpl();
    echo json_encode(array(
    "status" => $response["status"],
    
));    
 
  }
}

//SAVE SETTINGS 

if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["crf"]) && !empty($_POST["crf"]) && isset($_POST["audio"]) && !empty($_POST["audio"]) && isset($_POST["width"]) && !empty($_POST["width"])) { //Checks if action value exists
  
 
    
    
    $result = $db->query("DELETE FROM settings");
    
    $result = $db->query("INSERT INTO settings(crf,audio,width) VALUES (".$_POST["crf"].",".$_POST["audio"].",".$_POST["width"].")");
  
    
    echo json_encode(array(
    "crf" => $_POST["crf"],
    "audio" => $_POST["audio"],
    "width" => $_POST["width"],
    "status" => 2,
    
));    
    
  }
}



if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="reloadpl") { //Checks if action value exists
  
 
    
    
$result = $db->query("DELETE FROM bouquet WHERE private=0");
    
$opts = array(
  'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Basic " . base64_encode($conf["db_username"].":".$conf["db_password"])                 
  )
);



$context = stream_context_create($opts);

// Open the file using the HTTP headers set above
$bouquetsfile = file_get_contents("http://".$conf["db_ip"].":". $conf["db_web_port"]."/web/getallservices", false, $context);


$bouquetsxml = new SimpleXMLElement($bouquetsfile);


$xmlarray = (array)$bouquetsxml;

$sql = "BEGIN TRANSACTION";
$result = $db->query($sql) ;

$i=0;
foreach($xmlarray["e2bouquet"] as $e2bouquet){

       foreach ($e2bouquet as $e2servicelist) {

                foreach ($e2servicelist as $e2service) {

                             
                 $sql = "INSERT INTO bouquet(serviceref,group_name,service_name) VALUES ('".'http://'.$conf["db_ip"].':'.$conf["db_stream_port"].'/'.$e2service->e2servicereference."','".$e2bouquet->e2servicename."','".$e2service->e2servicename."') ";
                
             
                 $result = $db->query($sql) ;
                } 
     
       } 

}


$sql = "END TRANSACTION";
$result = $db->query($sql) ;
  
    
    echo json_encode(array(
    "status" => 4,
    
));    


    
  }
  
}

// DELETE ITEM FROM BOUQUETS
if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="delservice") { //Checks if action value exists
  
 
    
    
$result = $db->query("DELETE FROM bouquet WHERE id=\"".$_POST["id"]."\"");
    
//error_log("DELETE FROM bouquet WHERE serviceref=".$_POST["service"]);

  $responsearray["status"] = 10;
  $responsearray["hideclass"] = $_POST["id"];
     
  echo json_encode($responsearray);
  
  }
  
}

// END DELETE ITEM FROM BOUQUETS


// ADD ITEM FROM BOUQUETS
if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="addservice") { //Checks if action value exists
  
 
    
    
$result = $db->query("INSERT INTO bouquet(serviceref,group_name,service_name,private) VALUES ('".$_POST["service"]."','".$_POST["group"]."','".$_POST["name"]."',1)");

//error_log ("INSERT INTO bouquet(serviceref,group_name,service_name,private) VALUES ('".$_POST["service"]."','".$_POST["group"]."','".$_POST["name"]."',1)");
    
//error_log("DELETE FROM bouquet WHERE serviceref=".$_POST["service"]);

 $responsearray["status"] = 7;

  echo json_encode($responsearray); 
  
  }
  
}

// ADD ITEM FROM BOUQUETS







if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="trstatus" ) { //Checks if action value exists
  global $conf;
  global $db;	  
  $result = $db->query("SELECT count(*) AS C FROM pid");
  $row = $result->fetchArray();
  
  
	 
    if($row["C"] >  0 && file_exists($conf["stream_dir"]."ystream.m3u8")) {
    $response_array["status"] = 1;	   //runing
    }
    
    else if($row["C"] >  0 && !file_exists($conf["stream_dir"]."ystream.m3u8")) {
    $response_array["status"] = 5;	   //preparing
    }
    
    else  {
    $response_array["status"] = 0;	   //stopped
    }
    
  $result = $db->query("SELECT channel FROM pid LIMIT 1");
  $row = $result->fetchArray();  
    
    echo json_encode(array(
    "status" => $response_array["status"], 
    "service_name" => $row["channel"],  
));    
  
  }
}






//Function to check if the request is an AJAX request
function is_ajax() {
  if($_SESSION["authenticated"]==false) {
  return false;	
	logoff();
  } else {
  return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';
  }
}


function start($ref,$crf,$audio_id, $width) {
	 stop();//stop first any in progress transcodings
    $audio_id = $audio_id - 1; //default trac is 0 but in UI is used 1
    global $conf;
    global $db;
       
    $result = $db->query("SELECT count(*) AS C FROM pid");
    $row = $result->fetchArray();
	
    if($row["C"] >  0 && file_exists($conf["stream_dir"]."ystream.m3u8")) {
    $response_array["status"] = 0;	   //failed to start because seems avconv already conding	
    }	
    
    else {
	
	 cleanpl($conf["stream_dir"]."ystream.m3u8");
   
    $sql = "SELECT service_name FROM bouquet WHERE serviceref='".$ref."'"; 
    $result = $db->query($sql);
    $row = $result->fetchArray();   	 
    $service_name = $row["service_name"];  	  
    $stream_url = $ref ;
    $command = $conf["command"];	 
  	 $command = str_replace("{stream_url}",$stream_url,$command);
    $command = str_replace("{crf}",$crf,$command);
    $command = str_replace("{width}",$width,$command);
    $command = str_replace("{audio_id}",$audio_id,$command);
    $command = str_replace("{stream_dir}",$conf["stream_dir"],$command);
   
   
  	 error_log($command); //debug
    $process = new Process($command);
    
    $sql = "DELETE FROM pid" ;
    
    $result = $db->query($sql);
    
    $sql = "INSERT INTO pid(pid,url,crf,audio,scale,channel) VALUES (".$process->getPid().",\"".$stream_url ."\",".$crf.",".$audio_id.",".$width.",\"".$service_name."\")" ;
        
    $result = $db->query($sql);
    
    $response_array["stream_url"] = $stream_url;
    $response_array["audio_id"] = $audio_id;
    $response_array["width"] = $width;
    $response_array["pid"] = $process->getPid();
    $response_array["status"] =5;	
    $response_array["service_name"] = $service_name;
    
   }
   
   return $response_array;
} //end start

function stop() { //stop function
    global $conf;
    global $db;
    $result = $db->query("SELECT count(*) AS C FROM pid");
    $row = $result->fetchArray();



    // output data of each row
        $result = $db->query("SELECT * FROM pid LIMIT 1");
        $row = $result->fetchArray();
        $process = new Process();
        $process->setPid($row["pid"]);
 
        if (!$process->status()) {
         $sql = "DELETE FROM pid" ;
         $result = $db->query($sql);       
      
         $return_array["info"] = "process already dead";
         
   
        } else {
        	
         $response_array["pid"] = $process->getPid();
         $process->stop();
         $sql = "DELETE FROM pid" ;
         $result = $db->query($sql);
     
         $return_array["info"] = "process stopped";
     
        }

   sleep(1);
   cleanpl(); 


$return_array["status"] = 0;  
    
return $return_array;   

} //end stop
 

//cleaning playlist
function cleanpl()  {
	
global $conf;
$del = false;

if(file_exists($conf["stream_dir"]."ystream.m3u8")){

  while(!$del) {	
	
       $del = unlink($conf["stream_dir"]."ystream.m3u8");     

     } 
  }


} //cleaning playlist end

 //login check
	
if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="auth") { //Checks if action value exists
    global $conf;
    global $db;	
  
    if(($_POST["username"]==$conf["username"] && $_POST["password"] ==  $conf["password"])) {
 
        $_SESSION["authenticated"] = true; 
        $response_array["authenticated"] = true; 
  
  } else {
        $response_array["authenticated"] = false;  
        session_unset();
  }
  $response_array["status"] =6;  

    echo json_encode(array(
    "status" => $response_array["status"], 
    "authenticated" => $response_array["authenticated"] 
));  
}

if (is_ajax()) {
 
  global $conf;
  global $db;	
	
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="logoff") {
  logoff();
  } 

}

function logoff() {

  session_unset();
  session_destroy();  
  $response_array["authenticated"] = false;
  $response_array["status"] = 7;
  echo json_encode(array(
    "status" => $response_array["status"], 
    "authenticated" => $response_array["authenticated"] 
   ));  

}

//Get EPG
if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="getepg" && isset($_POST["service"]) && !empty($_POST["service"]) ) { //Checks if action value exists
  global $conf;
  global $db;	
  
  $opts = array(
  'http'=>array(
    'method'=>"GET",
    'header' => "Authorization: Basic " . base64_encode($conf["db_username"].":".$conf["db_password"])                 
  )
);

$context = stream_context_create($opts);




//$serviceref = str_replace( "http://".$conf["db_ip"].":".$conf["db_stream_port"]."/", '', $_POST["service"]);


error_log("debug:".cleanref($_POST["service"]));

$bouquetsfile = file_get_contents("http://".$conf["db_ip"].":". $conf["db_web_port"]."/web/epgservice?sRef=".cleanref($_POST["service"]), false, $context);

$bouquetsxml = new SimpleXMLElement($bouquetsfile);

$xmlarray = (array)$bouquetsxml;

$xmlarray["status"] = 8;

echo json_encode($xmlarray);  
  
  }
}

//Keep session Alive
if (is_ajax()) {
  if (isset($_POST["action"]) && !empty($_POST["action"]) && $_POST["action"]=="ping")
  {
  $responsearray["status"] = 9;
     
  echo json_encode($responsearray);
  
  }	


}


// getting group list 

if (isset($_GET["action"]) && !empty($_GET["action"]) && $_GET["action"]=="getlist")

{
  if($_SESSION["authenticated"]==false){die();}
  global $conf;
  global $db;	
  
 // echo "x";

$result = $db->query("SELECT group_name FROM bouquet GROUP BY group_name");
//echo $result;
$row = $result->fetchArray();

  while ($res= $result->fetchArray(1))
     {
     //insert row into array
     $responsearray[]=  $res["group_name"];
     }


  echo json_encode($responsearray);	
	
}



$db->close();

?>
