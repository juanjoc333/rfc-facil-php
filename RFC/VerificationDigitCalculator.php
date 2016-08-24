<?php

namespace RFC;


class VerificationDigitCalculator
{
    protected $rfc12digits;

    protected $MAPPING = [
        "0" => 0,
        "1" => 1,
        "2" => 2,
        "3" => 3,
        "4" => 4,
        "5" => 5,
        "6" => 6,
        "7" => 7,
        "8" => 8,
        "9" => 9,
        "A" => 10,
        "B" => 11,
        "C" => 12,
        "D" => 13,
        "E" => 14,
        "F" => 15,
        "G" => 16,
        "H" => 17,
        "I" => 18,
        "J" => 19,
        "K" => 20,
        "L" => 21,
        "M" => 22,
        "N" => 23,
        "&" => 24,
        "O" => 25,
        "P" => 26,
        "Q" => 27,
        "R" => 28,
        "S" => 29,
        "T" => 30,
        "U" => 31,
        "V" => 32,
        "W" => 33,
        "X" => 34,
        "Y" => 35,
        "Z" => 36,
        " " => 37,
        "Ñ" => 38
    ];

    /**
     * VerificationDigitCalculator constructor.
     * @param string $rfc12digits
     */
    public function __construct($rfc12digits)
    {
        $this->rfc12digits = $rfc12digits;
    }

    public function calculate(){
        $sum = 0;
        for($i = 0; $i < 12; $i++){
            $sum += ((int) $this->mapDigit(substr($this->rfc12digits, $i, 1))) * (13 - $i);
        }

        $reminder = $sum % 11;

        if($reminder === 0){
            return "0";
        } else {
            return strtoupper(dechex(11 - $reminder));
        }
    }

    protected function mapDigit($character){
        if(!$character || !array_key_exists($character, $this->MAPPING)){
            return 0;
        } else {
            return $this->MAPPING[$character];
        }
    }
}