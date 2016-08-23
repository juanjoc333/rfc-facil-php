<?php

namespace RFC\SpanishNumbers;


class FourthPeriod
{
    /**
     * @var int
     */
    private $number;

    /**
     * FourthPeriod constructor.
     * @param int $number
     */
    public function __construct($number)
    {

        $this->number = $number;
    }

    public function format(){
        $secondPeriod = new SecondPeriod($this->number);
        return $secondPeriod->format();
    }
}