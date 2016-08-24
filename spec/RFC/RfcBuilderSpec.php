<?php

namespace spec\RFC;

use RFC\Rfc;
use RFC\RfcBuilder;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RfcBuilderSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(RfcBuilder::class);
    }

    function it_should_build_rfc_for_a_natural_person(){
        $this->name("Josué")
        ->firstLastName("Zarzosa")
        ->secondLastName("de la Torre")
        ->birthday(5, 8, 1987)
        ->build()->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("ZATJ870805");
        $this->homoclave->shouldBeLike("CK");
        $this->verificationDigit->shouldBeLike("6");
        $this->build()->toString()->shouldReturn("ZATJ870805CK6");
    }

    function it_should_build_rfc_for_a_natural_person_with_verification_digit_1(){
        $this->name("ELIUD")
        ->firstLastName("OROZCO")
        ->secondLastName("GOMEZ")
        ->birthday(11, 7, 1952)
        ->build()->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("OOGE520711");
        $this->homoclave->shouldBeLike("15");
        $this->verificationDigit->shouldBeLike("1");
        $this->build()->toString()->shouldReturn("OOGE520711151");
    }

    function it_should_build_rfc_for_a_natural_person_with_verification_digit_A(){
        $this->name("SATURNINA")
            ->firstLastName("ANGEL")
            ->secondLastName("CRUZ")
            ->birthday(12, 11, 1921)
            ->build()
            ->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("AECS211112");
        $this->homoclave->shouldBeLike("JP");
        $this->verificationDigit->shouldBeLike("A");
        $this->build()->toString()->shouldReturn("AECS211112JPA");
    }

    function it_should_build_rfc_for_a_natural_person_with_verification_d(){
        $this->name("EMMA")
            ->firstLastName("GOMEZ")
            ->secondLastName("DIAZ")
            ->birthday(31, 12, 1956)
            ->build()
            ->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("GODE561231");
        $this->homoclave->shouldBeLike("GR");
        $this->verificationDigit->shouldBeLike("8");
        $this->build()->toString()->shouldReturn("GODE561231GR8");
    }

    function it_should_build_rfc_for_a_juristic_person_test_1(){
        $this->legalName("AUTOS PULLMAN, S.A. DE C.V.")
            ->creationDate(30, 9, 1964)
            ->build()
            ->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("APU640930");
        $this->homoclave->shouldBeLike("KV");
        $this->verificationDigit->shouldBeLike("9");
        $this->build()->toString()->shouldReturn("APU640930KV9");
    }

    function it_should_build_rfc_for_a_juristic_person_test_2(){
        $this->legalName("TPS EMPRESARIAL")
            ->creationDate(23, 2, 2009)
            ->build()
            ->shouldHaveType(Rfc::class);

        $this->tenDigitsCode->shouldBeLike("TEM090223");
        $this->homoclave->shouldBeLike("NE");
        $this->verificationDigit->shouldBeLike("1");
        $this->build()->toString()->shouldReturn("TEM090223NE1");
    }
}
