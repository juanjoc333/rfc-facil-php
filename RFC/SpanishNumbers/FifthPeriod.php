<?php

namespace RFC\SpanishNumbers;


class FifthPeriod
{
    /**
     * @var int
     */
    private $number;
    /**
     * @var int
     */
    private $periodSize;

    /**
     * FifthPeriod constructor.
     * @param int $number
     * @param int $periodSize
     */
    public function __construct($number, $periodSize)
    {

        $this->number = $number;
        $this->periodSize = $periodSize;
    }

    public function format(){
        if($this->number === 0 && $this->periodSize > 5){
            return "billones ";
        } elseif ($this->number === 0){
            return "";
        } elseif ($this->number === 1) {
            return "un billón ";
        } else {
            $firstPeriod = new FirstPeriod($this->number, 1);

            return $firstPeriod->format() . " billones ";
        }
    }
}