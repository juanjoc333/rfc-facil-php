<?php

namespace RFC;


class RomanNumerals
{
    protected static $ROMAN_NUMERAL = "/^(M{0,4})(CM|CD|D?C{0,3})(XC|XL|L?X{0,3})(IX|IV|V?I{0,3})$/";

    static function isRomanNumeral($word)
    {
        return preg_match(self::$ROMAN_NUMERAL, trim($word));
    }

    static function parseInt($number){
        if(empty($number)) return 0;
        if(strpos($number, "M")     === 0)  return 1000 + self::parseInt(substr($number, 1));
        if(strpos($number, "CM")    === 0)  return 900 + self::parseInt(substr($number, 2));
        if(strpos($number, "D")     === 0)  return 500 + self::parseInt(substr($number, 1));
        if(strpos($number, "CD")    === 0)  return 400 + self::parseInt(substr($number, 2));
        if(strpos($number, "C")     === 0)  return 100 + self::parseInt(substr($number, 1));
        if(strpos($number, "XC")    === 0)  return 90 + self::parseInt(substr($number, 2));
        if(strpos($number, "L")    === 0)   return 50 + self::parseInt(substr($number, 1));
        if(strpos($number, "XL")    === 0)  return 40 + self::parseInt(substr($number, 2));
        if(strpos($number, "X")    === 0)   return 10 + self::parseInt(substr($number, 1));
        if(strpos($number, "IX")    === 0)   return 9 + self::parseInt(substr($number, 2));
        if(strpos($number, "V")    === 0)   return 5 + self::parseInt(substr($number, 1));
        if(strpos($number, "IV")    === 0)   return 4 + self::parseInt(substr($number, 2));
        if(strpos($number, "I")    === 0)   return 1 + self::parseInt(substr($number, 1));

        throw new \InvalidArgumentException("No roman numeral recognized");
    }
}