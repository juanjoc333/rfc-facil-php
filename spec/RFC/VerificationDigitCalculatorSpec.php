<?php

namespace spec\RFC;

use RFC\VerificationDigitCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class VerificationDigitCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->beConstructedWith("123");
        $this->shouldHaveType(VerificationDigitCalculator::class);
    }

    function it_should_calculate_verification_digit_test_1(){
        $this->beConstructedWith("GODE561231GR");
        $this->calculate()->shouldReturn("8");
    }

    function it_should_calculate_verification_digit_test_2(){
        $this->beConstructedWith("AECS211112JP");
        $this->calculate()->shouldReturn("A");
    }

    function it_should_calculate_verification_digit_test_3(){
        $this->beConstructedWith("OOGE52071115");
        $this->calculate()->shouldReturn("1");
    }
}
