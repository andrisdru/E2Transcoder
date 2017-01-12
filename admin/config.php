<?php
 //mandatory configuration
 $conf["username"] = "root"; //username to access DB transcoder
 $conf["password"] = "password"; //password to access DB transcoder
 $conf["callreceiver"] = 0; // if enigma2 receiver is not used must be 0, but it is not mandatory if receiver is used
 
 //enigma2 receiver configuration
 $conf["db_username"] = "root"; //enigma2 user name
 $conf["db_password"] = "password"; //enigma2 password
 $conf["db_ip"] ="192.168.2.197"; //enigma2 IP
 $conf["db_web_port"]="80"; //enigma2 WEB interface port
 $conf["db_stream_port"]="8001"; //enigma2 stream port

   
 

 // Advanced settings
 $conf["stream_dir"]="C:\\DB\\web\\stream\\"; //full path of stream dir 
 $conf["command"] = "C:\\DB\\ff\\bin\\ffmpeg.exe";   // path of avconv or ffmpeg executable , if avconv of ffmpeg installed from package only need executable nam 
 $conf["parameters"] = "-i {stream_url} -c:a aac -q:a 1 -strict experimental -c:v libx264 -crf {crf}  -profile:v baseline -filter:v yadif -vf \"scale=trunc(oh*a/2)*2:min({width} \,iw)\" -r 24 -map 0:a:{audio_id} -map 0:v:0 -hls_time 10 -hls_wrap 6 {stream_dir}ystream.m3u8";  
 $conf["database"] = "db/dbtranscode.db" ; //sqlite database path
 $conf["stream_log"] = "c:\\windows\\temp\\dblog.txt" ; //full path of avconv or ffmpeg log
 $conf["stream_web_dir"] = "/stream/"; //web url folder of stream if necessary change 8000 port to your web servers port

 //Bellow this line do not edit
 $conf["command"] =  $conf["command"] . " " . $conf["parameters"];



?>