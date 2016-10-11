<?php

namespace spec\RFC;

use RFC\JuristicPerson;
use RFC\JuristicPersonTenDigitCalculator;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JuristicPersonTenDigitCalculatorSpec extends ObjectBehavior
{
    function it_is_initializable($person)
    {
        $person->beADoubleOf(JuristicPerson::class);
        $this->beConstructedWith($person);

        $this->shouldHaveType(JuristicPersonTenDigitCalculator::class);
    }

    function it_should_take_first_letters_from_the_first_three_words_from_legal_name(){
        $person = new JuristicPerson("Sonora Industrial Azucarera, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate();
        $this->threeDigitsCode()->shouldReturn("SIA");
    }

    function it_should_take_creation_date_in_format_yy_mm_dd(){
        $person = new JuristicPerson("Sonora Industrial Azucarera, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("SIA821129");
    }

    function it_should_prepend_zero_to_one_digit_numbers_in_creation_month_and_day_date(){
        $person = new JuristicPerson("Sonora Industrial Azucarera, S. de R.L.", 05, 02, 1983);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("SIA830205");
    }

    function it_should_prepend_zero_to_one_digit_numbers_in_creation_day_date(){
        $person = new JuristicPerson("Sonora Industrial Azucarera, S. de R.L.", 05, 12, 1983);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("SIA831205");
    }

    function it_should_prepend_zero_to_one_digit_numbers_in_creation_month_date(){
        $person = new JuristicPerson("Sonora Industrial Azucarera, S. de R.L.", 15, 02, 1983);

        $this->beConstructedWith($person);
        $this->calculate()->shouldReturn("SIA830215");
    }

    function it_should_consider_abreviations_as_if_they_where_words_test_1(){
        $person = new JuristicPerson("F.A.Z., S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("FAZ");
    }

    function it_should_consider_abreviations_as_if_they_where_words_test_2(){
        $person = new JuristicPerson("U.S. Ruber Mexicana, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("USR");
    }

    function it_should_consider_abreviations_as_if_they_where_words_test_3(){
        $person = new JuristicPerson("H. Prieto y Martínez, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("HPM");
    }

    function it_should_ignore_common_juristic_person_type_abbreviations_test_1(){
        $person = new JuristicPerson("Guantes Industriales Guadalupe, S. en C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIG");
    }

    function it_should_ignore_common_juristic_person_type_abbreviations_test_2(){
        $person = new JuristicPerson("Construcciones Metálicas Mexicanas, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CMM");
    }

    function it_should_ignore_common_juristic_person_type_abbreviations_test_3(){
        $person = new JuristicPerson("Fundición de Precisión Eutectic, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("FPE");
    }

    function it_should_ignore_abbreviation_SA_DE_CV_test_1(){
        $person = new JuristicPerson("Guantes Industriales, S.A. de C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_abbreviation_SA_DE_CV_test_2(){
        $person = new JuristicPerson("Guantes Industriales, SA de CV", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_abbreviation_SCL_test_1(){
        $person = new JuristicPerson("Guantes Industriales, S.C.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_abbreviation_SCL_test_2(){
        $person = new JuristicPerson("Guantes Industriales, SCL", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_1(){
        $person = new JuristicPerson("Guantes Industriales, S.C.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_2(){
        $person = new JuristicPerson("Guantes Industriales, SCL", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_3(){
        $person = new JuristicPerson("Guantes Industriales, S. en C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_4(){
        $person = new JuristicPerson("Guantes Industriales, S en C", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_5(){
        $person = new JuristicPerson("Guantes Industriales, S. en C. por A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_6(){
        $person = new JuristicPerson("Guantes Industriales, S en C por A", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_7(){
        $person = new JuristicPerson("Guantes Industriales, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_8(){
        $person = new JuristicPerson("Guantes Industriales, SA", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_9(){
        $person = new JuristicPerson("Guantes Industriales, S.C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_10(){
        $person = new JuristicPerson("Guantes Industriales, SC", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_11(){
        $person = new JuristicPerson("Guantes Industriales, S.A. de C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_12(){
        $person = new JuristicPerson("Guantes Industriales, SA de CV", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_13(){
        $person = new JuristicPerson("Guantes Industriales, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_14(){
        $person = new JuristicPerson("Guantes Industriales, S de RL", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_15(){
        $person = new JuristicPerson("Guantes Industriales, S. en N.C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_16(){
        $person = new JuristicPerson("Guantes Industriales, S en NC", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_17(){
        $person = new JuristicPerson("Guantes Industriales, S.N.C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_18(){
        $person = new JuristicPerson("Guantes Industriales, SNC", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_19(){
        $person = new JuristicPerson("Guantes Industriales, A.C.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_20(){
        $person = new JuristicPerson("Guantes Industriales, AC", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_21(){
        $person = new JuristicPerson("Guantes Industriales, A. en P.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_22(){
        $person = new JuristicPerson("Guantes Industriales, A en P", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_23(){
        $person = new JuristicPerson("Guantes Industriales, S.C.S.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_ignore_all_juristic_person_type_abreviations_test_24(){
        $person = new JuristicPerson("Guantes Industriales, SCS", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GIN");
    }

    function it_should_use_first_and_second_letters_of_second_word_if_only_two_words_are_elegible_test_1(){
        $person = new JuristicPerson("Aceros Ecatepec, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("AEC");
    }

    function it_should_use_first_and_second_letters_of_second_word_if_only_two_words_are_elegible_test_2(){
        $person = new JuristicPerson("Fonograbaciones Cinelandia, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("FCI");
    }

    function it_should_use_first_and_second_letters_of_second_word_if_only_two_words_are_elegible_test_3(){
        $person = new JuristicPerson("Distribuidora Ges, S.A. ", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("DGE");
    }

    function it_should_use_first_three_letters_of_first_word_if_only_one_word_is_elegible_test_1(){
        $person = new JuristicPerson("Arsuyama, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ARS");
    }

    function it_should_use_first_three_letters_of_first_word_if_only_one_word_is_elegible_test_2(){
        $person = new JuristicPerson("Calidra, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CAL");
    }

    function it_should_use_first_three_letters_of_first_word_if_only_one_word_is_elegible_test_3(){
        $person = new JuristicPerson("Electrólisis, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ELE");
    }

    function it_should_fill_with_character_X_if_only_one_word_is_elegible_and_is_smaller_than_3_characters_long_test_1(){
        $person = new JuristicPerson("Al, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ALX");
    }

    function it_should_fill_with_character_X_if_only_one_word_is_elegible_and_is_smaller_than_3_characters_long_test_2(){
        $person = new JuristicPerson("Z, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ZXX");
    }

    function it_should_ignore_articles_prepositions_conjunctions_and_contractions_test_1(){
        $person = new JuristicPerson("El abastecedor Ferretero Electrico, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("AFE");
    }

    function it_should_ignore_articles_prepositions_conjunctions_and_contractions_test_2(){
        $person = new JuristicPerson("Cigarros la Tabacalera Mexicana, S.A. de C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CTM");
    }

    function it_should_ignore_articles_prepositions_conjunctions_and_contractions_test_3(){
        $person = new JuristicPerson("Los Viajes Internacionales de Marco Polo, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("VIM");
    }

    function it_should_ignore_articles_prepositions_conjunctions_and_contractions_test_4(){
        $person = new JuristicPerson("Artículos y Accesorios para Automóviles, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("AAA");
    }

    function it_should_ignore_articles_prepositions_conjunctions_and_contractions_test_5(){
        $person = new JuristicPerson("Productos de la Industria del Papel, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("PIP");
    }

    function it_should_translate_arabic_numerals_and_treat_them_as_words_test_1(){
        $person = new JuristicPerson("El 12, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("DOC");
    }

    function it_should_translate_arabic_numerals_and_treat_them_as_words_test_2(){
        $person = new JuristicPerson("El 2 de Enero, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("DEN");
    }

    function it_should_translate_arabic_numerals_and_treat_them_as_words_test_3(){
        $person = new JuristicPerson("El 505, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("QCI");
    }

    function it_should_translate_roman_numerals_and_treat_them_as_words(){
        $person = new JuristicPerson("Editorial Siglo XXI, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ESV");
    }

    function it_should_ignore_the_word_compania_and_its_abbreviation_test_1(){
        $person = new JuristicPerson("Compañía Periodística Nacional Electrica, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("PNE");
    }

    function it_should_ignore_the_word_compania_and_its_abbreviation_test_2(){
        $person = new JuristicPerson("Cía. De Artículos Nacionales Eléctricos, S. de R.L.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ANE");
    }

    function it_should_ignore_the_word_compania_and_its_abbreviation_test_3(){
        $person = new JuristicPerson("Cía. Nal. De Subsistencias Mexicanas, S.A.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("NSM");
    }

    function it_should_ignore_the_word_sociedad_and_its_abbreviation_test_1(){
        $person = new JuristicPerson("Sociedad Cooperativa de Producción Agrícola de Michoacán", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CPA");
    }

    function it_should_ignore_the_word_sociedad_and_its_abbreviation_test_2(){
        $person = new JuristicPerson("Soc. de Consumo Agrícola del Sur, S.C.L. ", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CAS");
    }

    function it_should_exclude_special_characters_test_1(){
        $person = new JuristicPerson("LA S@NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_2(){
        $person = new JuristicPerson("EL C@FE.NET", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CFE");
    }

    function it_should_exclude_special_characters_test_3(){
        $person = new JuristicPerson("LA S@NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_4(){
        $person = new JuristicPerson("LA S'NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_5(){
        $person = new JuristicPerson("LA S%NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_6(){
        $person = new JuristicPerson("LA S#NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_7(){
        $person = new JuristicPerson("LA S!NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_8(){
        $person = new JuristicPerson("LA S.NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_9(){
        $person = new JuristicPerson("LA S\$NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_10(){
        $person = new JuristicPerson("LA S\"NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_11(){
        $person = new JuristicPerson("LA S-NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_12(){
        $person = new JuristicPerson("LA S/NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_13(){
        $person = new JuristicPerson("LA S+NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_14(){
        $person = new JuristicPerson("LA S(NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_exclude_special_characters_test_15(){
        $person = new JuristicPerson("LA S)NDIA S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SND");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_1(){
        $person = new JuristicPerson("LA @ S.A DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ARR");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_2(){
        $person = new JuristicPerson("LA @ DEL % SA DE CV", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("APO");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_3(){
        $person = new JuristicPerson("@ COMER.COM", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ACO");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_4(){
        $person = new JuristicPerson("LAS ( BLANCAS )", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("APB");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_5(){
        $person = new JuristicPerson("EL # DEL TEJADO", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("NTE"); // this example is wrong in the official documentation
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_6(){
        $person = new JuristicPerson("LA / DEL SUR", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("DSU");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_7(){
        $person = new JuristicPerson("LA . S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("PUN");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_8(){
        $person = new JuristicPerson("LA ' S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("APO");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_9(){
        $person = new JuristicPerson("LA ! S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("ADM");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_10(){
        $person = new JuristicPerson("LA $ S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("PES");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_11(){
        $person = new JuristicPerson("LA \" S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("COM");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_12(){
        $person = new JuristicPerson("LA - S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("GUI");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_13(){
        $person = new JuristicPerson("LA + S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("SUM");
    }

    function it_should_expand_special_characters_that_appear_in_a_singleton_word_test_14(){
        $person = new JuristicPerson("LA ) S.A. DE C.V.", 29, 11, 1982);

        $this->beConstructedWith($person);
        $this->calculate()->shouldStartWith("CPA");
    }
}