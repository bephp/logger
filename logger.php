<?php
/**
 * @lloydzhou https://github.com/bephp/logger
 */

function logger($path, $cond = true) {

    $logs = array();

    register_shutdown_function(function() use ($path, &$logs){

        $fd = fopen($path, 'a+');

        foreach($logs as $log)
            if ($msg = count($log) > 1 
                ? call_user_func_array('sprintf', $log)
                : array_shift($log))
                fwrite($fd, $msg."\n");

        fclose($fd);

    });

    $cond = is_callable($cond) ? call_user_func($cond) : !!($cond);

    return function () use ($cond, &$logs) {
        return $cond ? $logs[] = func_get_args() : false;
    };
}
