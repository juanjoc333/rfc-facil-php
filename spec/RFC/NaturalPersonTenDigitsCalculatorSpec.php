<?php

namespace spec\RFC;

use RFC\NaturalPerson;
use RFC\NaturalPersonTenDigitsCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NaturalPersonTenDigitsCalculatorSpec extends ObjectBehavior
{

    function it_should_calculate_ten_digits_code_for_simple_test_case()
    {
        $person = new NaturalPerson("Juan", "Barrios", "Fernandez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("BAFJ701213");
    }

    function it_should_calculate_ten_digits_code_for_date_after_year_2000()
    {
        $person = new NaturalPerson("Juan", "Barrios", "Fernandez", 1, 12, 2001);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("BAFJ011201");
    }

    function it_should_exclude_special_particles_in_both_last_names()
    {
        $person = new NaturalPerson("Eric", "Mc Gregor", "Von Juarez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("GEJE701213");
    }

    function it_should_exclude_special_particles_in_the_first_last_name()
    {
        $person = new NaturalPerson("Josue", "Zarzosa", "de la Torre", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("ZATJ701213");
    }

    function it_should_exclude_special_particles_in_the_second_last_name()
    {
        $person = new NaturalPerson("Antonio", "Jiménez", "Ponce de León", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("JIPA701213");
    }

    function it_should_use_first_word_of_compound_first_last_name()
    {
        $person = new NaturalPerson("Antonio", "Ponce de León", "Juarez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("POJA701213");
    }

    function it_should_use_use_first_two_letters_of_first_name_if_first_last_name_has_just_one_letter()
    {
        $person = new NaturalPerson("Alvaro", "de la O", "Lozano", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("OLAL701213");
    }

    function it_should_use_use_first_two_letters_of_first_name_if_first_last_name_has_just_two_letters()
    {
        $person = new NaturalPerson("Ernesto", "Ek", "Rivera", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("ERER701213");
    }

    function it_should_use_first_name_if_person_has_multiple_names()
    {
        $person = new NaturalPerson("Luz María", "Fernández", "Juárez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("FEJL701213");
    }

    function it_should_use_second_name_if_person_has_multiple_names_and_first_name_is_jose()
    {
        $person = new NaturalPerson("José Antonio", "Camargo", "Hernández", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("CAHA701213");
    }

    function it_should_use_second_name_if_person_has_multiple_names_and_first_name_is_maria()
    {
        $person = new NaturalPerson("María Luisa", "Ramírez", "Sánchez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("RASL701213");
    }

    function it_should_use_first_two_letters_of_second_last_name_if_empty_first_last_name_is_provided()
    {
        $person = new NaturalPerson("Juan", "", "Martínez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("MAJU701213");
    }

    function it_should_use_first_two_letters_of_second_last_name_if_null_first_last_name_is_provided()
    {
        $person = new NaturalPerson("Juan", null, "Martínez", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("MAJU701213");
    }

    function it_should_use_first_two_letters_of_first_last_name_if_empty_second_last_name_is_provided()
    {
        $person = new NaturalPerson("Gerarda", "Zafra", "", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("ZAGE701213");
    }

    function it_should_use_first_two_letters_of_first_last_name_if_null_second_last_name_is_provided()
    {
        $person = new NaturalPerson("Gerarda", "Zafra", null, 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("ZAGE701213");
    }

    function it_should_replace_last_letter_with_X_if_code_makes_forbidden_word()
    {
        $person = new NaturalPerson("Ingrid", "Bueno", "Ezquerra", 13, 12, 1970);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("BUEX701213");
    }
}
