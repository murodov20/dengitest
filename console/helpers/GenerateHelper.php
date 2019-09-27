<?php


namespace console\helpers;


class GenerateHelper
{

    public static function generateOrderNumber()
    {
        return mt_rand(1, 20);
    }

    public static function generateCommission()
    {
        return mt_rand(50, 200) / 100.0;
    }

    public static function generateSum()
    {
        return mt_rand(1000, 50000) / 100.0;
    }

    public static function generateSalt()
    {
        return \Yii::$app->security->generateRandomString(16);
    }

    public static function calculateHash($attrs, $separator = ';', $function = 'md5')
    {
        $str = join($separator, $attrs);
        return hash($function, $str);
    }
}