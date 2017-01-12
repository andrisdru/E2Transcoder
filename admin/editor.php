  
       <br>




<div class="col-md-4" >
 <div id="prefetch">
  <input id="URL" class="form-control typeahead" type="text" placeholder="URL">
</div> 
</div> <!-- col-md-4 -->


<div class="col-md-4" >
 <div id="prefetch">
  <input id="Name" class="form-control typeahead" type="text" placeholder="Name">
</div> 
</div> <!-- col-md-3 -->

<div class="col-md-4" >
 <div id="prefetch">
  <input id="Group" class="form-control typeahead" type="text" placeholder="Group">
</div> 
</div> <!-- col-md-4 -->

 <br>
 <br>



<button class="col-xs-12  btn btn-primary btn-large" onclick="saveitem($('#URL').val(),$('#Name').val(),$('#Group').val());"><i class="glyphicon glyphicon-floppy-disk"></i>Save</button>


  <br>
  <br>
  <br>

   
   
   
   
   
   
   
   
   
   <div id="MainMenu">
  


  
  
  <script>
var countries = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.whitespace,
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  // url points to a json file that contains an array of country names, see
  // https://github.com/twitter/typeahead.js/blob/gh-pages/data/countries.json
  prefetch: 'control.php?action=getlist'
});

// passing in `null` for the `options` arguments will result in the default
// options being used
$('#prefetch .typeahead').typeahead(null, {
  name: 'countries',
  source: countries
});
  </script>
  
  
  
  
  
  
  
  
  
  
  
  
 
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
        <span  class=\"list-group-item ".$crow["id"]."\">
       <span style=\"display: inline-block;min-width:65%;max-width:65%;\" >".$crow["service_name"]."</span>
        <button style=\"min-width:30%;max-width:30%;\" type=\"button\" class=\"btn btn-warning\" onclick=\"delservice('".$crow["id"]."');  \"> Delete </button>
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
