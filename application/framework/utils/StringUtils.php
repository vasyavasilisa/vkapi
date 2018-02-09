<?php

namespace Application\Framework\Utils;


final class StringUtils
{

    private static $sizeText = 100;

    private function __construct()
    {
    }

    public static function generateRandLetter()
    {
        $a_z = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ .,!?";
        $int = rand(0, strlen($a_z) - 1);
        $rand_letter = $a_z[$int];
        return $rand_letter;
    }

    public static function generateRandText()
    {
        $randForLength = rand(0, self::$sizeText);
        $string = "";
        for ($i = 0; $i < $randForLength; $i++) {
            $string .= self::generateRandLetter();
        }
        return $string;
    }
}