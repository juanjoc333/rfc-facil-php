<?php

namespace RFC\SpanishNumbers;


class SpanishNumbers
{
    /**
     * @param int $number
     * @return string
     */
    public static function cardinal($number){
        $context = new DigitList($number);

        $sixthPeriod = new SixthPeriod($context->periods[5]);
        $fifthPeriod = new FifthPeriod($context->periods[4], $context->periodSize);
        $fourthPeriod = new FourthPeriod($context->periods[3]);
        $thirdPeriod = new ThirdPeriod($context->periods[2], $context);
        $secondPeriod = new SecondPeriod($context->periods[1]);
        $firstPeriod = new FirstPeriod($context->periods[0], $context->periodSize);

        $result = sprintf("%s%s%s%s%s%s",
            $sixthPeriod->format(), $fifthPeriod->format(), $fourthPeriod->format(),
            $thirdPeriod->format(), $secondPeriod->format(), $firstPeriod->format());

        return $result;
    }
}