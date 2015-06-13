<script type="text/javascript">
            
 $(document).ready(function() {
       trstat(); 	
       setInterval('ping()',20000); 	
       screenwidth = $( window ).width();     
       
       if (screenwidth<800) {
        
       $( '#hlsplayer' ).attr( 'width', screenwidth );
       $( '#hlsplayer' ).attr( 'height', ((screenwidth/16)*9) );
       }
       else {
       $( '#hlsplayer' ).attr( 'width', 720 );
       $( '#hlsplayer' ).attr( 'height', 405 );
       	
       }
       
});            
</script>

<?php 
echo '<div class="text-center">';
echo '<p>Do not save this ystream.m3u8 file to computer, but paste full HTML link in VLC player!</p>';
echo '<span class="label label-success"><a href="'. $conf["stream_web_dir"].'ystream.m3u8" class="text-warning">LINK TO STREAM URL</a></span>';
echo '</div>';
?>

<br>
<div class="text-center">
	     <iframe  id="hlsplayer" src="hls/player.php?controls=true&amp;autoplay=false&amp;loop=false&amp;cast=false" frameborder="0" allowfullscreen="true" webkitallowfullscreen="true" mozallowfullscreen="true" scrolling="no"></iframe>
</div>   