<?php 


class Process{
    private $pid;
    private $command;
 

    public function __construct($cl=false){
        if ($cl != false){
            $this->command = $cl;
            $this->runCom();
        }
    }
    
    private function runCom(){
        
        $WshShell = new COM("WScript.Shell");
        
        //echo $this->command;
        error_log($this->command);
        $oExec = $WshShell->exec($this->command);
        $this->pid  = $oExec->ProcessID;    
    }

    public function setPid($pid){
        $this->pid = $pid;
    }

    public function getPid(){
        return $this->pid;
    }

    public function status(){
        $command = 'cmd /c tasklist /fi "PID eq '.$this->pid.'"';
        $WshShell = new COM("WScript.Shell");
        $oExec = $WshShell->exec($command);

        $op =  $oExec->StdOut->ReadAll;
            
        if (!strpos($op,"PID"))return false;
        else return true;
        //return $op;
        
    }

    public function start(){
        if ($this->command != '')$this->runCom();
        else return true;
    }

    public function stop(){
  
        $command = 'cmd /c taskkill /f /PID '.$this->pid;
        error_log($command);
 
        $WshShell = new COM("WScript.Shell");
        $oExec = $WshShell->exec($command);

        if ($this->status() == false)return true;
        else return false;
    }
}


?>