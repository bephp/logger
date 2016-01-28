<?php
function logger($path, $cond = true) {
   $logs = array();
   register_shutdown_function(function() use ($path, &$logs){
       $fd = fopen($path, 'a+');
       foreach($logs as $log){
           $msg = count($log) > 1 ? call_user_func_array('sprintf', $log) : array_shift($log);
           if($msg) fwrite($fd, $msg."\n");
       }
       fclose($fd);
   });
   return function () use ($cond, &$logs) {
       return (is_callable($cond) ? call_user_func($cond) : !!($cond))
           ? $logs[] = func_get_args() : false;
   };
}
