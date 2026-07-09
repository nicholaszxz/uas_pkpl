<?php

namespace App\Helper;

class Helper
{
    public static function money_format($number = 0, $currency = '', $separate = '.')
    {
        if (strpos(strval($number), '.')) {
            $number = explode('.', $number);
            $decimal = (int)$number[1] == 0 ? '' : ',' . str_pad($number[1], 1, "0", STR_PAD_LEFT);
            do {
                $decimal = rtrim($decimal, "0");
            } while (substr($decimal, -1) == "0");
            return $currency . number_format($number[0], 0, ',', $separate) . $decimal;
        } else {
            return $currency . number_format($number, 0, ',', $separate);
        }
    }

    public static function replace_money($number = 0)
    {
        return (int)str_replace('.', '', preg_replace('/Rp /', '', $number));
    }
}
