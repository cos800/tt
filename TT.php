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

    static function error($msg='操作失败', $next='back') {
        $data = [
            'msg' => $msg,
            'next' => $next,
        ];
        $resp = view(__DIR__.'/view/error.phtml', compact('data'));
        throw new \think\exception\HttpResponseException($resp);
    }

    static function redirect($url, $raw=false) {
        if (!$raw) $url = url($url);
        throw new \think\exception\HttpResponseException(redirect($url));
    }
}