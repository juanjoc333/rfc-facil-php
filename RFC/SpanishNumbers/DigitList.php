<?php

namespace RFC\SpanishNumbers;


use Exception;

class DigitList
{
    /**
     * @var int
     */
    protected static $MAX_COUNT = 19; // strlen(PHP_INT_MAX);
    /**
     * @var int
     */
    protected static $MAX_PERIODS = 7; // (int) ceil(MAX_COUNT / 3)

    /**
     * @var string
     */
    protected $digits;
    /**
     * @var int[]
     */
    public $periods;
    /**
     * @var int
     */
    public $periodSize;

    /**
     * DigitList constructor.
     * @param int $number
     * @throws Exception
     */
    public function __construct($number)
    {
        if($number > PHP_INT_MAX){
            throw new Exception("El valor provisto sobrepasa el límite calculable en PHP para los tipos int");
        }

        $this->digits = str_split(str_pad(sprintf("%s", $number), self::$MAX_COUNT, "0", STR_PAD_LEFT));
        $this->buildPeriods();
        $this->periodSize = $this->getPeriodSize();
    }

    protected function buildPeriods(){
        $this->periods[self::$MAX_PERIODS - 1] = (int) $this->digits[0];

        for($i = 3; $i < count($this->digits); $i+=3) {
            $index = 6 - ($i / 3);
            $this->periods[$index]
                = (int) sprintf("%s%s%s", $this->digits[$i - 2], $this->digits[$i - 1], $this->digits[$i]);
        }
    }

    protected function getPeriodSize(){
        $size = count($this->periods) - 1;

        for($i = $size; $i >= 0; $i--){
            if($this->periods[$i] === 0){
                $size--;
            } else {
                return $size;
            }
        }

        return $size;
    }
}