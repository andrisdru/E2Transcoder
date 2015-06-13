<?php
 //mandatory configuration
 $conf["db_username"] = "root"; //dreambox user name
 $conf["db_password"] = "password"; //dreambox password
 $conf["db_ip"] ="192.168.1.120"; //dreambox IP
 $conf["db_web_port"]="80"; //dreambox WEB interface port
 $conf["db_stream_port"]="8001"; //dreambox stream port
 $conf["stream_dir"]="/opt/web/www/video/stream/"; //full path of stream dir 
 $conf["command"] = "/opt/ff/ffmpeg";   // path of avconv or ffmpeg executable , if avconv of ffmpeg installed from package only need executable name
 //$conf["command"] = "avconv";   // path of avconv or ffmpeg executable , if avconv of ffmpeg installed from package only need executable name
 $conf["stream_web_dir"] = "/video/stream/"; //web url folder of stream
 $conf["username"] = "transcoder"; //username and password to access transcoder
 $conf["password"] = "password"; 
 

 // Advanced settings
 $conf["parameters"] = "-i {stream_url} -c:a aac -q:a 1 -strict experimental -c:v libx264 -crf {crf}  -profile:v baseline -filter:v yadif -vf \"scale=trunc(oh*a/2)*2:min({width} \,iw)\" -r 24 -map 0:a:{audio_id} -map 0:v:0 -hls_time 10 -hls_wrap 6 {stream_dir}ystream.m3u8";  
 $conf["database"] = "db/dbtranscode.db" ; //sqlite database path
 $conf["stream_log"] = "/tmp/stream.log" ; //full path of avconv or ffmpeg log


 //Bellow this line do not edit
 $conf["command"] =  $conf["command"] . " " . $conf["parameters"];



?>