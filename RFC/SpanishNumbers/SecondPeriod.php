<?php

namespace RFC\SpanishNumbers;


class SecondPeriod
{
    /**
     * @var int
     */
    private $number;

    /**
     * SecondPeriod constructor.
     * @param int $number
     */
    public function __construct($number)
    {
        $this->number = $number;
    }

    public function format(){
        if($this->number === 0){
            return "";
        } elseif($this->number === 1) {
            return "mil ";
        } else {
            $firstPeriod = new FirstPeriod($this->number, 1);
            return $firstPeriod->format() . " mil ";
        }
    }
}