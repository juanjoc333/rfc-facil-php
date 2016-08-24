<?php

namespace spec\RFC;

use RFC\HomoclaveCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use RFC\HomoclavePerson;
use RFC\NaturalPerson;

class HomoclaveCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable($person)
    {
        $person->beADoubleOf(HomoclavePerson::class);

        $this->beConstructedWith($person);
        $this->shouldHaveType(HomoclaveCalculator::class);
    }

    function it_should_calculate_homoclave_for_simple_test_case(){
        $person = new NaturalPerson("Juan", "Perez", "Garcia", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("LN");
    }

    function it_should_calculate_same_homoclave_for_names_with_and_without_accents(){
        $person = new NaturalPerson("Juan", "Pérez", "García", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("LN");
    }

    function it_should_calculate_homoclave_for_person_with_more_than_one_name(){
        $person = new NaturalPerson("Jose Antonio", "Del real", "Anzures", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("N9");
    }

    function it_should_calculate_homoclave_for_name_with_n_with_tilde(){
        $person = new NaturalPerson("Juan", "Muñoz", "Ortega", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("T6");
    }

    function it_should_calculate_homoclave_for_name_with_ampersand(){
        $person = new NaturalPerson("Juan", "Perez&Gomez", "Garcia", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("2R");
    }

    function it_should_calculate_same_homoclave_for_name_with_and_without_special_characters_test_1(){
        $person = new NaturalPerson("Juan", "Mc.Gregor", "O'Connor-Juarez", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("5I");
    }

    function it_should_calculate_same_homoclave_for_name_with_and_without_special_characters_test_2(){
        $person = new NaturalPerson("Juan", "McGregor", "OConnorJuarez", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("5I");
    }

    function it_should_calculate_different_homoclave_for_names_with_and_without_ampersand_test_1(){
        $person = new NaturalPerson("Juan", "Perez&Gomez", "Garcia", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("2R");
    }

    function it_should_calculate_different_homoclave_for_names_with_and_without_ampersand_test_2(){
        $person = new NaturalPerson("Juan", "PerezGomez", "Garcia", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("2Q");
    }

    function it_should_calculate_same_homoclave_for_different_birthdays_test_1(){
        $person = new NaturalPerson("Juan", "Perez", "Garcia", 1, 1, 1901);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("LN");
    }

    function it_should_calculate_same_homoclave_for_different_birthdays_test_2(){
        $person = new NaturalPerson("Juan", "Perez", "Garcia", 1, 1, 1984);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("LN");
    }
}
