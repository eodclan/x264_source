<?php
/*
    +----------------------------------------------------------------+
    |   LinuxStat                                                    |
    +----------------------------------------------------------------+
    |   This PHP class will gather information about the status of   |
    |   a GNU/Linux machine. All the information is gather from the  |
    |   /proc filesystem.                                            |
    +----------------------------------------------------------------+
    |   The author disclaims all copyrights about this script        |
    +----------------------------------------------------------------+
    |   2008 Copyleft César D. Rodas. All bad reserved               |
    +----------------------------------------------------------------+
*/


/**
 *  This class retrive information about a Linux machine
 *
 *  @author César D. Rodas <mail@cesarodas.com>
 *  @copyright Copyleft (c) 2008, César Rodas
 */
class linuxstat {
    var $ldir = "/proc";
    
    /**
     *  Return an array containing information about the CPU
     *  of a given machine.
     *  @return array  
     */
    function getCpuInfo() {
        return $this->parsefile($this->ldir."/cpuinfo");
    }
    
    /**
     *  Return the memory stats
     *  @return array
     */
    function getMemStat() {
        return $this->parsefile($this->ldir."/meminfo");
    }
    
    /**
     *  Return a list of all process that can be visible
     *  by the user which is executing PHP (usually apache)
     *
     *  @return array
     */
    function getProcesses() {
        $files = $this->getDirFiles($this->ldir);
        $processes=array();
        foreach($files as $file) {
            if ( $file['dir'] && is_numeric($file['name']) ) {
                $process['pid'] = $file['name'];
                $process['cmd'] = file_get_contents($this->ldir."/".$file['name']."/cmdline");
                if ( $process['cmd']=="") continue;
                $processes[] = $process;
            }
        }
        return $processes;
    }
    
    /**
     *  Return process details
     *      - cmd : Command that launch this process
     *      - cwd : Current working directory *
     *      - exe : Executable path *
     *      - root: Root dir, usually / or anyother if the process
     *        run with chroot. *
     *      - write bytes
     *      - read bytes
     *      - opened_files: A list of files opened by this process
     *
     *  * = Only avaiable if the user can access this information. 
     *  
     *  @return array|false
     */
    function getProcessDetail($pid) {
        $dir = $this->ldir."/".$pid;
        if ( !is_dir($dir) ) return false;
        $info=array();
        $info['cmd'] = file_get_contents("${dir}/cmdline");
        foreach(array('cwd','exe','root') as $proc) {
            $r = @readlink("${dir}/$proc");;
            if ( !$r) continue;
            $info[$proc] = $r;
        }
        /* IO stats */
        $io_stat = $this->parsefile("${dir}/io");
        $info['write bytes'] = $io_stat['write_bytes'];
        $info['read bytes']  = $io_stat['read_bytes'];
        /* opened files */
        $info['opened_files'] = &$fd;
        $fd = array();
        for($i=0; $i < 2000;$i++){
            $rl = @readlink("${dir}/fd/${i}");
            if ( !$rl ) continue;
            $fd[$i] = $rl;
        }
        return $info;
    }
    
    /**
     *  Parse a file by key : value
     *  @private
     */
    function parsefile($file) {
        $content = file_get_contents($file);
        $info=array();
        foreach( explode("\n",$content) as $line) {
            $pos = strpos($line,":");
            $key = trim( substr($line,0,$pos) );
            $val = trim( substr($line,$pos+1) );
            if ( $key=="") continue;
            $info[$key] = $val;
        }
        return $info;        
    }
    /**
     * @private
     */
    function getDirFiles($pdir) {
        $dir = opendir($pdir);
        $files = array();
        while ( $f = readdir($dir) ) {
            if ( $f=="." || $f == "..") continue;
            $files[] = array('name'=>$f,'dir'=>is_dir("${pdir}/${f}"));
        }
        closedir($dir);
        return $files;
    }
}
?>