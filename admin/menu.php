  <div id="MainMenu">
  <div class="list-group panel">

<?php 
$q = "SELECT group_name FROM bouquet GROUP BY group_name ORDER BY group_name";

$gresult = $db->query($q);
while( $grow = $gresult->fetchArray()) {
	$group = clean($grow["group_name"]);
    echo "<a href=\"#".$group."\" class=\"list-group-item list-group-item-success\" data-toggle=\"collapse\" data-parent=\"#MainMenu\">".$group."</a>
    <div class=\"collapse\" id=\"".$group."\">";
      
      
       $q = "SELECT * FROM bouquet WHERE  group_name=\"".$grow["group_name"]."\"";
       //echo $q;       
       $cresult = $db->query($q);
    
       while( $crow = $cresult->fetchArray()) {
       //echo"<a href=\"javascript:;\"  onclick=\"zap(\"".$crow["serviceref"]."\");\" class=\"list-group-item\">".$crow["service_name"]."</a>";
        echo"
        <span  class=\"list-group-item\">
        <button style=\"min-width:65%;max-width:65%;\" type=\"button \" class=\"btn \" onclick=\"zap('".$crow["serviceref"]."');\"> ".$crow["service_name"]."</button>
        <button style=\"min-width:30%;max-width:30%;\" type=\"button\" class=\"btn \" onclick=\"getepg('".$crow["serviceref"]."'); $('#myModal').modal('show'); \" data-target=\"#myModal\" \"> EPG </button>
        </span>";
        echo ""; 
        //<button style=\"min-width:30%;max-width:30%;\" type=\"button\" class=\"btn btn-info \" data-toggle=\"modal\" data-target=\"#myModal\" \"> EPG </button>     
      }
      echo "</div>"; //group 
   }
   
   
?>

<script type='text/javascript'>
 $(document).ready(function() {
       trstat();
     
     
});            


</script>
    
  </div> <!-- list-group panel -->
</div>  <!-- Main menu -->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="  margin-top: 50px; margin-bottom:50px;">

    <!-- Modal content-->
    <div class="modal-content">
     
      <div class="modal-header">
      <!--<button type="button" class="close" data-dismiss="modal">&times;</button> -->
        <h4 id="mtitle" class="modal-title">EPG</h4>
      </div>
      <div id="mbody1" class="modal-body" style="max-height:65vh; text-align: center; overflow-y: scroll">

<!-- EPG TEBALE GOES HERE -->       
        
    
     <div id="mbody"></div>
      
      </div>
      <div class="modal-footer">
        <button type="button" class="btn" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
