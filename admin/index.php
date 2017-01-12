<?php

session_start();

require("config.php");

if (strncasecmp(PHP_OS,'WIN',3)==0) {
include_once("wrun.php");
}

else {
include_once("lrun.php");
}




require("functions.php");

include("header.php");


if($_SESSION["authenticated"]==true) {

if(isset($_GET["t"])) {
	
if($_GET["t"]=="c")
  { 
    $activetab = "c"; 
  }
else if($_GET["t"]=="s")
  { 
    $activetab = "s"; 
  }
else if($_GET["t"]=="l")
  { 
    $activetab = "l"; 
  }  
else if($_GET["t"]=="e")
  { 
    $activetab = "e"; 
  }  

}
else { 
    $activetab = "c"; 
} //by default showing channel list 
}

else {

$activetab = "a";

}




if($activetab == "c")
  { 
  include("tabs.php");  
  include("menu.php"); 
  }
 
else if(  $activetab == "s")
  { 
  include("tabs.php");  
  include("settings.php");
  }
  
else if(  $activetab == "l")
  { 
  include("tabs.php");
  include("live.php");  
  }  
  
else if(  $activetab == "e")
  { 
  include("tabs.php");
  include("editor.php");  
  }  
  
else if(  $activetab == "a")
  { 
  include("auth.php");  
  }    
  



include("footer.php");

$db->close(); 
?>