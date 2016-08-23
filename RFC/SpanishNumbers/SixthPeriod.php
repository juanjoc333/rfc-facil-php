<?php

namespace RFC\SpanishNumbers;


class SixthPeriod
{
    /**
     * @var int
     */
    private $number;

    /**
     * SixthPeriod constructor.
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