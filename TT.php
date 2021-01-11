<?php


class TT
{
    static function enJson($var) {
        return json_encode($var, JSON_UNESCAPED_UNICODE);
    }

    static function deJson($str) {
        return json_decode($str, true);
    }

    static function setUnlimit($flush=false) {
        set_time_limit(0) OR die('set_time_limit fail');
        if ($flush) {
            ob_end_flush() OR die('ob_end_flush fail');
        }else{
            ob_end_clean() OR die('ob_end_clean fail');
        }
        ob_implicit_flush();
        header('X-Accel-Buffering: no');
    }
}