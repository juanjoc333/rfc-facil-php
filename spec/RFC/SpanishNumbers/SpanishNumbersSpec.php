<?php

namespace spec\RFC\SpanishNumbers;

use RFC\SpanishNumbers\SpanishNumbers;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class SpanishNumbersSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(SpanishNumbers::class);
    }

    function it_converts_units_to_spanish_number_string(){
        $this->cardinal(0)->shouldReturn("cero");
        $this->cardinal(1)->shouldReturn("uno");
        $this->cardinal(2)->shouldReturn("dos");
        $this->cardinal(3)->shouldReturn("tres");
        $this->cardinal(4)->shouldReturn("cuatro");
        $this->cardinal(5)->shouldReturn("cinco");
        $this->cardinal(6)->shouldReturn("seis");
        $this->cardinal(7)->shouldReturn("siete");
        $this->cardinal(8)->shouldReturn("ocho");
        $this->cardinal(9)->shouldReturn("nueve");
    }

    function it_converts_tens_to_spanish_number_string(){
        $this->cardinal(10)->shouldReturn("diez");
        $this->cardinal(12)->shouldReturn("doce");
        $this->cardinal(19)->shouldReturn("diecinueve");
        $this->cardinal(20)->shouldReturn("veinte");
        $this->cardinal(21)->shouldReturn("veintiuno");
        $this->cardinal(29)->shouldReturn("veintinueve");
        $this->cardinal(30)->shouldReturn("treinta");
        $this->cardinal(31)->shouldReturn("treinta y uno");
        $this->cardinal(39)->shouldReturn("treinta y nueve");
        $this->cardinal(40)->shouldReturn("cuarenta");
        $this->cardinal(41)->shouldReturn("cuarenta y uno");
        $this->cardinal(49)->shouldReturn("cuarenta y nueve");
        $this->cardinal(50)->shouldReturn("cincuenta");
        $this->cardinal(51)->shouldReturn("cincuenta y uno");
        $this->cardinal(59)->shouldReturn("cincuenta y nueve");
        $this->cardinal(60)->shouldReturn("sesenta");
        $this->cardinal(61)->shouldReturn("sesenta y uno");
        $this->cardinal(69)->shouldReturn("sesenta y nueve");
        $this->cardinal(70)->shouldReturn("setenta");
        $this->cardinal(71)->shouldReturn("setenta y uno");
        $this->cardinal(79)->shouldReturn("setenta y nueve");
        $this->cardinal(80)->shouldReturn("ochenta");
        $this->cardinal(81)->shouldReturn("ochenta y uno");
        $this->cardinal(89)->shouldReturn("ochenta y nueve");
        $this->cardinal(90)->shouldReturn("noventa");
        $this->cardinal(91)->shouldReturn("noventa y uno");
        $this->cardinal(99)->shouldReturn("noventa y nueve");
    }

    function it_converts_cents_to_spanish_number_string(){
        $this->cardinal(100)->shouldReturn("cien");
        $this->cardinal(101)->shouldReturn("ciento uno");
        $this->cardinal(110)->shouldReturn("ciento diez");
        $this->cardinal(111)->shouldReturn("ciento once");
        $this->cardinal(121)->shouldReturn("ciento veintiuno");
        $this->cardinal(130)->shouldReturn("ciento treinta");
        $this->cardinal(199)->shouldReturn("ciento noventa y nueve");
        $this->cardinal(200)->shouldReturn("doscientos");
        $this->cardinal(300)->shouldReturn("trescientos");
        $this->cardinal(400)->shouldReturn("cuatrocientos");
        $this->cardinal(500)->shouldReturn("quinientos");
        $this->cardinal(600)->shouldReturn("seiscientos");
        $this->cardinal(700)->shouldReturn("setecientos");
        $this->cardinal(800)->shouldReturn("ochocientos");
        $this->cardinal(900)->shouldReturn("novecientos");
        $this->cardinal(999)->shouldReturn("novecientos noventa y nueve");
    }

    function it_converts_thousands_to_spanish_number_string(){
        $this->cardinal(1000)->shouldReturn("mil ");
        $this->cardinal(1001)->shouldReturn("mil uno");
        $this->cardinal(1010)->shouldReturn("mil diez");
        $this->cardinal(1110)->shouldReturn("mil ciento diez");
        $this->cardinal(2000)->shouldReturn("dos mil ");
        $this->cardinal(3000)->shouldReturn("tres mil ");
        $this->cardinal(3333)->shouldReturn("tres mil trescientos treinta y tres");
        $this->cardinal(4000)->shouldReturn("cuatro mil ");
        $this->cardinal(5000)->shouldReturn("cinco mil ");
        $this->cardinal(6000)->shouldReturn("seis mil ");
        $this->cardinal(7000)->shouldReturn("siete mil ");
        $this->cardinal(8000)->shouldReturn("ocho mil ");
        $this->cardinal(9999)->shouldReturn("nueve mil novecientos noventa y nueve");
        $this->cardinal(100224)->shouldReturn("cien mil doscientos veinticuatro");
        $this->cardinal(999999)->shouldReturn("novecientos noventa y nueve mil novecientos noventa y nueve");
    }

    function it_converts_millions_to_spanish_number_string(){
        $this->cardinal(1000000)->shouldReturn('un millón ');
        $this->cardinal(1000001)->shouldReturn('un millón uno');
        $this->cardinal(1000010)->shouldReturn('un millón diez');
        $this->cardinal(1455789)->shouldReturn('un millón cuatrocientos cincuenta y cinco mil setecientos ochenta y nueve');
        $this->cardinal(1000000000)->shouldReturn('mil millones ');
        $this->cardinal(2400000000)->shouldReturn('dos mil cuatrocientos millones ');
    }

    function it_converts_billions_to_spanish_number_string(){
        $this->cardinal(1000000000000)->shouldReturn("un billón ");
        $this->cardinal(9000000000000)->shouldReturn("nueve billones ");
        $this->cardinal(9240000000001)->shouldReturn("nueve billones doscientos cuarenta mil millones uno");
        $this->cardinal(9999999999999)->shouldReturn("nueve billones novecientos noventa y nueve mil novecientos noventa y nueve millones novecientos noventa y nueve mil novecientos noventa y nueve");
    }
}
