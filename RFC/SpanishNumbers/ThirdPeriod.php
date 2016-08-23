<?php

namespace RFC\SpanishNumbers;


class ThirdPeriod
{
    /**
     * @var int
     */
    private $number;
    /**
     * @var DigitList
     */
    private $context;

    /**
     * ThirdPeriod constructor.
     * @param int $number
     * @param DigitList $context
     */
    public function __construct($number, DigitList $context)
    {
        $this->number = $number;
        $this->context = $context;
    }

    public function format() {
        if($this->number === 0 && $this->context->periods[3] !== 0){
            return "millones ";
        } elseif($this->number === 0) {
            return "";
        } elseif($this->number === 1) {
            return "un millón ";
        } else {
            $firstPeriod = new FirstPeriod($this->number, 1);
            return $firstPeriod->format() . " millones ";
        }
    }
}