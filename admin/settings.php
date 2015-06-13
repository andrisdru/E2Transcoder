<?php
    $result = $db->query("SELECT * FROM settings LIMIT 1");
    $row = $result->fetchArray();  
?>


<br>
 <div class="text-center">

 
  <label>Audio Track</label>
  <div class="form-group">
  <input type="text"  class="form-control" value="" data-slider-min="1" data-slider-max="8" data-slider-step="1" data-slider-value="<?php echo $row["audio"]; ?>" id="sl2" >
  </div> 
  
   
  
  <label>Compression</label>
  <div class="form-group">
  <input type="text"  class="form-control" value="" data-slider-min="15" data-slider-max="52" data-slider-step="1" data-slider-value="<?php echo $row["crf"]; ?>"  id="sl" >
  </div>  
 
 
  
<div class="row">
    <div class="col-lg-2 col-lg-offset-5">
    <div class="form-group">
    <label for="Width">Width</label>
    <input type="text" class="form-control" id="Width" value="<?php echo $row["width"]; ?>">
  </div>


  <button class="btn btn-warning btn-large" onclick="bpush();" >
  <i class="glyphicon glyphicon-floppy-disk"></i> Save</button>
  <br>
   <br>
  
    <button class="btn btn-warning btn-large" onclick="reloadpl();" >
  <i class="glyphicon glyphicon-repeat"></i> Reload Playlist</button>
  <br>
 


    </div><!-- /.col-lg-4 -->
</div><!-- /.row -->
 
</div>  <!-- /.center --> 

<script type='text/javascript'>
function bpush(){
	
  if ($('#sl').val()!='') {
   	tcrf = $('#sl').val();
  } else {
   	tcrf = $('#sl').attr('data-slider-value');
  }	
  
  	
  if ($('#sl2').val()!='') {
  	taud = $('#sl2').val();
  } else {
  	taud = $('#sl2').attr('data-slider-value');
  }	
	
	
  savesettings( tcrf,taud,$('#Width').val() ); 
  

}


 $(document).ready(function() {
       trstat(); 	
       $('#sl').slider();
       $('#sl2').slider();	
	 
     
});
     </script>






