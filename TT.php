<?php


class TT
{
    static function enJson($var) {
        return json_encode($var, JSON_UNESCAPED_UNICODE);
    }

    static function deJson($str) {

        return json_decode($str, true);
    }
}