
    function sendajax(data) {
    data = $(this).serialize() + "&" + $.param(data);
       
    	request = $.ajax({
            type: 'POST',
            dataType: "json",
            url: 'control.php', 
            data: data,
            //async: false
            
        });
      request.done(function (response, textStatus, jqXHR){
        // Log a message to the console
        console.log(response);
        if (response["status"]==1) {  
        
        $("#status").html(response["service_name"]);        
        
        oldstatus = $("#status1").html();      
        $("#status1").html('runing');           
        $("#istatus1").addClass("gly-spin");
        
        //reload player iframe  and start play stream    
        
        console.log(oldstatus);
    
        if (oldstatus=='preparing') {//setting timeout 5sec after stream is ready
        
        setTimeout(function(){ 
        
        $( '#hlsplayer' ).attr( 'src', function ( i, val ) { return val; });   
        
           }, 11000);
        }   
        
        
         
        
        } //start
        if (response["status"]==0) {  
        $("#status").html('NA');
        $("#status1").html('NA');

        $("#istatus1").removeClass('gly-spin');
        
        //reload player iframe and stop stream
        //setTimeout(function(){ 
        
        $( '#hlsplayer' ).attr( 'src', function ( i, val ) { return val; });   
        
        //}, 1000);        
        
        
        } //stop
        
        
        
        
        if (response["status"]==2) {  $("#status1").html('Settings Saved'); } //playlist Reloaded
       // if (response["status"]==3) {  $("#status").html(response["service_name"]); } //save
        if (response["status"]==4) {  $("#status1").html('Bouquets Reloaded'); } //playlist Reloaded
        if (response["status"]==5) 
        {      
         
          $("#status1").html('preparing'); 
          $("#status").html(response["service_name"]);

          $("#istatus1").addClass('gly-spin');
          setTimeout(trstat, 1000);
        
         }
         
         
        if (response["status"]==6)   
        
        {  
        if(response["authenticated"]==true) {
        $("#login").html('Login OK!');  
        location.reload();
        console.log("login");
        }
        
        else {
        	
        $("#login").html('Login Failed!');   
        console.log("false");  
        } 
       } //login
       
       
      if (response["status"]==7) {  
      location.reload();
      } //logoff    
      
      if (response["status"]==10) {  
      //location.reload();
      console.log(response["hideclass"]);
      $("." + response["hideclass"] ).children().hide(); 
      $("." + response["hideclass"] ).hide(); 
      } //deleteclass bouquet    
      
      
      
      if (response["status"]==8) {  

       if (typeof response.e2event == 'undefined') {
       	
       	$('#mbody').html('NO EPG</br> Zap to this channel or start transcoding to load EPG.');
} else {
	
	
	       
       $('#mtitle').html(response.e2event[0].e2eventservicename+' - EPG - '+timeConverter(response.e2event[0].e2eventcurrenttime));

       var epgtable;
       var trclass;
       
       epgtable = '<table class="table table-bordered"><thead><tr class="success"><th>Time</th><th>Event Title</th></tr></thead>';
       
       $.each( response.e2event, function( key, epgvalue ) {
       
       trclass = key == 0 ? 'danger' : 'info';
       
       epgtable = epgtable + '<tr class="'+trclass+'"><td>' + timeConverter(epgvalue.e2eventstart) + '</td>' + '<td>' + epgvalue.e2eventtitle + '</td>' + '</tr>';
     
});
epgtable = epgtable + '</tbody></table>';
}

      
      $('#mbody').html(epgtable);
  
      
//  console.log(response);

     
       
    }  //load EPG      
             
});
}    	



function zap(serviceref)
    {
 
    var data = { "service": serviceref,
                 "action": "start", 
               }  
    console.log(data);           
    sendajax(data);
 
    trstat();
    
    }
    
function delservice(id)
    {
 
    var data = { "id": id,
                 "action": "delservice", 
               }  
    console.log(data);           
    sendajax(data);

    
    }
    
    
    
    
    
    
function trstat() {
    var data = { "action":"trstatus"}
    sendajax(data);

}    
    
    
    
    
    function stopencode() {
    var data = { "action":"stop"}
    sendajax(data);
    }    
    
    function savesettings(crf,audio,width) {

    var data = { "crf": crf,
                 "audio": audio,
                 "width": width
               }
    var res;
   
    sendajax(data);

    }  
    
    
    function saveitem(url,name,group) {
    	
       var data = { "service": url,
                 "name": name,
                 "group": group,
                 "action": "addservice"
               }
    console.log(data);           
    sendajax(data);          
    	
    }
    
    
   
    
    function reloadpl() {
    $("#status1").html('Transfering Bouquets from receiver');	
    var data = { "action":"reloadpl"}
    console.log(data);
    sendajax(data);
    
    }  
     
    function getepg(service) {

   $('#mbody').html('<span id="istatus1" style="font-size:1.5em;" class="glyphicon glyphicon-refresh gly-spin" aria-hidden="true"></span>');    
    
    var data = { "action":"getepg",
                 "service": service,
               }
    console.log(data);
    sendajax(data);
    
    }     
    
    
    function auth() {
    var data = { "username":document.getElementById('userName').value,
                 "password":document.getElementById('userPassword').value,
                 "action":"auth"
               }
    console.log(data);
    sendajax(data);
    
    }  
    
    function logoff() {
    var data = { "action":"logoff"}
    console.log(data);
    sendajax(data);
    }  
    
    function ping() {
    var data = { "action":"ping"}
    sendajax(data);
    }  
    
    
$( document ).ready(function() {
    
    $("body").css("padding-top", $('#yalert').height()+55);
    
});

$( window ).resize(function() {
	
	  $("body").css("padding-top", $('#yalert').height()+55);
	
});
    
function timeConverter(UNIX_timestamp){
  var a = new Date(UNIX_timestamp*1000);
  var months = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
  var year = a.getFullYear();
  var month = months[a.getMonth()];
  var date = a.getDate();
  var hour = a.getHours();
  var min = a.getMinutes() < 10 ? '0' + a.getMinutes() : a.getMinutes();
  var sec = a.getSeconds() < 10 ? '0' + a.getSeconds() : a.getSeconds();
  var time = date + ',' + month + ' ' + year + ' ' + hour + ':' + min;//+ ':' + sec ;
  return time;
}

//typeahead     	


//end typeahead         
                
    
