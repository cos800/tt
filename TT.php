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

    static function curl($url, $get=false, $post=false) {

        if ($get) {
            if (!is_string($get)) {
                $get = http_build_query($get);
            }
            if (strpos($url, '?')===false) {
                $url .= '?';
            }else{
                $url .= '&';
            }
            $url .= $get;
        }

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        if ($post) {
            $post = http_build_query($post);
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $post);
        }

        $resp = curl_exec($curl);

        if (curl_error($curl)) {
            $error_msg = curl_error($curl);
            $error_no = curl_errno($curl);
            curl_close($curl);
            throw new \Exception($error_msg, $error_no);
        }

        return $resp;

    }

    static function curlJson($url, $get=false, $post=false) {
        $resp = self::curl($url, $get, $post);

        if (!$resp) {
            throw new Exception('response is empty');
        }

        $json = self::deJson($resp);

        if (!$json) {
            throw new Exception('json decode fail: '.$resp);
        }

        return $json;
    }
}