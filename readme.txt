This product is licensed under GPL.

In this product is included many other components which may have own licenses.

PHP, Video.JS, momovi.com , bootstrap, sqlite and many more

/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/*/**/*/*/*/*/*/

How to Install E2 Transcoder

Installation steps for windows 

This manual is how to install Enigma2 Transcoder on Windows Computer.

1. Download last application version from here http://e2transcoder.megaurl.it/download/

2. Extract archive to disk c: . Transocer works only if it is extracted on disk c:\DB

3. Edit file c:\DB\web\admin\config.php , set here receiver IP, username etc..

4. Start c:\DB\start.bat

5. Open link http://yourcomputerip:8888/admin/ on browser

6. under settings push button “reload playlist”, this will download bouquets to application

Installation steps for ubuntu linux

For linux it is necessary already installed web server with php installed, but i would not go into details how to install web server. Application should work on nginx and on apache.

1. Download last application version from here http://e2transcoder.megaurl.it/download/

2. Copy from archive /DB/web folders admin and stream somewhere to your web server path. Folders /admin/db and /stream/ should be writable by web server. In case of apache this is user apache for nginx www-data.

3. Sqlite database engine and avconv command it is necessary for transcoding, so let install em.

sudo apt-get install php5-sqlite libav-tools

4. Delete from folder /admin/ file config.php and rename config.linux_example.php to config.php.

5. edit this config.php file according your needs. As ubuntu uses avlib, command is avconv for converting video. For linux distributives with ffmpeg , ffmpeg can be used.

$conf[“command”]=”avconv”;

6. Open link http://yourwebserver/pathtoadminfolder/admin

7. under settings push button “reload playlist”, this will download bouquets to application

Notes:

If in “start.bat” window you see error probably you need install  VC11 redistributable X86

http://www.microsoft…s.aspx?id=30679

web server port for windows installation you can change in start.bat file

Basically E2 transcoder can run also  on linux or windows computer, with any other web server like IIS, apache, nginx which supports PHP.

Support:

If you have any problems with installing and runing this application you can get support in OpenPLI form thread

http://forums.openpli.org/topic/37361-db-transcoder/

Or support in Latvian Language:

http://www.boot.lv/forums/index.php?/forum/52-sattv-ciparutv/

Or contact with me by email

spameris@gmail.com
