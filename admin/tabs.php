<div id="yalert" class="navbar navbar-fixed-top alert alert-warning red" role="alert">
  
  <!-- <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button> -->


 <div class="row">
 <div class="col-xs-11">

 <?php 

 
 if ( $conf["callreceiver"] == 1) {
 	
 echo " <span class=\"glyphicon glyphicon-picture\" aria-hidden=\"true\"></span>";
 echo "<strong> TV: </strong>".current_channel()["e2service"]->e2servicename; 


 }
 
  echo "<br><span id=\"istatus\"class=\"glyphicon glyphicon-film \" aria-hidden=\"true\"></span> <span id=\"status\"></span>";
  echo " <br><span id=\"istatus1\" class=\"glyphicon glyphicon-refresh \" aria-hidden=\"true\"></span> <span id=\"status1\">NA</span>";
 
 ?>
 
 




 </div>   <!-- col div -->
 </div> <!-- row div -->
 </div> <!-- alert div -->


<div class="container-fluid">
<div class="row">
<?php 

 if ( $conf["callreceiver"] == 1) {

echo "<button class=\"col-xs-5  btn btn-warning btn-large\" onclick=\"zap('"."http://". $conf["db_ip"].":".$conf["db_stream_port"]."/".current_channel()["e2service"]->e2servicereference."');\"><i class=\"glyphicon glyphicon-play\"></i> Start Current</button>"; 
}

else 
{
	
echo "<button class=\"col-xs-5  btn btn-warning btn-large\" onclick=\"zap('"."http://". $conf["db_ip"].":".$conf["db_stream_port"]."/".current_channel()["e2service"]->e2servicereference."');\" disabled><i class=\"glyphicon glyphicon-play\" ></i> Start Current</button>"; 
	
}

?>
<button class="col-xs-2  btn btn-danger btn-large" onclick="logoff();"><i class="glyphicon glyphicon-off"></i> Exit</button>
<button class="col-xs-5  btn btn-warning btn-large" onclick="stopencode();"><i class="glyphicon glyphicon-stop"></i> Stop Transcoding</button>
</div> 
<br>
</div>
<?php  

if ($activetab == "c") 
{
echo "
<ul class=\"nav nav-tabs\">
  <li role=\"presentation\" class=\"active\" ><a href=\"?t=c\">Channels</a></li>  
  <li role=\"presentation\"><a href=\"?t=l\">Live</a></li>
  <li role=\"presentation\"><a href=\"?t=s\">Settings</a></li>
  <li role=\"presentation\" ><a href=\"?t=e\">Editor</a></li>

</ul>";
} else if ($activetab == "l")

{
echo "
<ul class=\"nav nav-tabs\">
  <li role=\"presentation\" ><a href=\"?t=c\">Channels</a></li>  
  <li role=\"presentation\" class=\"active\" ><a href=\"?t=l\">Live</a></li>
  <li role=\"presentation\"><a href=\"?t=s\">Settings</a></li>
  <li role=\"presentation\" ><a href=\"?t=e\">Editor</a></li>

</ul>";

} else if ($activetab == "s")

{
echo "
<ul class=\"nav nav-tabs\">
  <li role=\"presentation\" ><a href=\"?t=c\">Channels</a></li>  
  <li role=\"presentation\" ><a href=\"?t=l\">Live</a></li>
  <li role=\"presentation\" class=\"active\"><a href=\"?t=s\">Settings</a></li>
  <li role=\"presentation\" ><a href=\"?t=e\">Editor</a></li>

</ul>";

} else if ($activetab == "e")

{
echo "
<ul class=\"nav nav-tabs\">
  <li role=\"presentation\" ><a href=\"?t=c\">Channels</a></li>  
  <li role=\"presentation\" ><a href=\"?t=l\">Live</a></li>
  <li role=\"presentation\" ><a href=\"?t=s\">Settings</a></li>
  <li role=\"presentation\" class=\"active\"><a href=\"?t=e\">Editor</a></li>
</ul>";

} 





?>