<?php
/**
 * @lloydzhou https://github.com/bephp/logger
 */

function logger($path = 'php.log', $cond = true) {

    $logs = array();

    register_shutdown_function(function() use ($path, &$logs){

        @file_put_contents($path, implode(array_map(function($log){

            return count($log) > 1 ? call_user_func_array('sprintf', $log) : current($log);

        }, $logs), PHP_EOL). PHP_EOL, FILE_APPEND | LOCK_EX);

    });

    $cond = is_callable($cond) ? call_user_func($cond) : !!($cond);

    return function () use ($cond, &$logs) {

        return $cond && func_num_args() > 0 ? $logs[] = func_get_args() : false;

    };
}

