<?php

namespace RFC;


use RFC\SpanishNumbers\SpanishNumbers;

class JuristicPersonTenDigitCalculator
{
    /**
     * @var string
     */
    public static $JURISTIC_PERSON_TYPE = "/(S\\.?\\s?EN\\s?N\\.?\\s?C\\.?|" .
                                            "S\\.?\\s?EN\\s?C\\.?\\s?POR\\s?A\\.?|" .
                                            "S\\.?\\s?EN\\s?C\\.?|" .
                                            "S\\.?\\s?DE\\s?R\\.?\\s?L\\.?|" .
                                            "S\\.?\\s?DE\\s?R\\.?\\s?L\\.?\\s?DE\\s?C\\.?\\s?V\\.?|" .
                                            "S\\.?\\s?A\\.?\\s?DE\\s?C\\.?\\s?V\\.?|" .
                                            "A\\.?\\s?EN\\s?P\\.?|" .
                                            "S\\.?\\s?C\\.?\\s?[LPS]\\.?|" .
                                            "S\\.?\\s?[AC]\\.?|" .
                                            "S\\.?\\s?N\\.?\\s?C\\.?|" .
                                            "A\\.?\\s?C\\.?)$/";

    /**
     * @var array
     */
    public static $SPECIAL_CHARACTERS_IN_SINGLETON_WORD = [
        "@"     => "ARROBA",
        "'"     => "APOSTROFE",
        "%"     => "PORCIENTO",
        "#"     => "NUMERO",
        "!"     => "ADMIRACION",
        "\\."     => "PUNTO",
        "\\$"     => "PESOS",
        "\""    => "COMILLAS",
        "-"     => "GUION",
        '\\/'     => "DIAGONAL",
        "\\+"     => "SUMA",
        '\\('     => "ABRE PARENTESIS",
        '\\)'     => "CIERRA PARENTESIS"
    ];

    /*
    * This list is based on Anexo V from the official documentation
    * but some words have been commented out because the examples from
    * the same documentation contradict the list
    */
    /**
     * @var array
     */
    public static $FORBIDDEN_WORDS = [
        "EL", "LA", "DE", "LOS", "LAS", "Y", "DEL", "MI",
        "POR", "CON", /*"AL",*/ "SUS", "E", "PARA", "EN",
        "MC", "VON", "MAC", "VAN",
        "COMPANIA", "CIA", "CIA.",
        "SOCIEDAD", "SOC", "SOC.",
        "COMPANY", "CO",
            /*"COOPERATIVA", "COOP",*/
        "SC", "SCL", "SCS", "SNC", "SRL", "CV", "SA",
        "THE", "OF", "AND", "A",
    ];
    /**
     * @var array
     */
    protected $words;

    /**
     * @var JuristicPerson
     */
    private $person;

    /**
     * JuristicPersonTenDigitCalculator constructor.
     * @param JuristicPerson $person
     */
    public function __construct(JuristicPerson $person)
    {
        $this->person = $person;
    }

    public function calculate(){
        $legalName = $this->ignoreJuristicPersonTypeAbbreviations($this->normalize($this->person->legalName));

        $this->words = $this->expandRomanNumerals(
                            $this->expandArabicNumerals(
                                $this->splitOneLetterAbbreviations(
                                    $this->ignoreSpecialCharactersInWords(
                                        $this->expandSpecialCharactersInSingletonWord(
                                            $this->markOneLetterAbbreviations(
                                                $this->ignoreForbiddenWords(
                                                    $this->splitWords($legalName))))))));

        return sprintf("%s%s", $this->threeDigitsCode(), $this->birthdayCode());
    }

    /**
     * @param string $string
     * @return string
     */
    protected function normalize($string)
    {
        if(empty($string)){
            return $string;
        } else {
            return trim(strtoupper(StringUtils::remove_accents($string)));
        }
    }

    /**
     * @param string $string
     * @return mixed
     */
    protected function ignoreJuristicPersonTypeAbbreviations($string)
    {
        return preg_replace(self::$JURISTIC_PERSON_TYPE, "", $string);
    }

    /**
     * @param string $string
     * @return array
     */
    protected function splitWords($string)
    {
        return array_filter(preg_split("/[,\\s]+/", $string), function($item){
            return !empty($item);
        });
    }

    /**
     * @param array $words
     * @return array
     */
    protected function ignoreForbiddenWords($words)
    {
        $validWord = array_map(function($word){
            if(!in_array($word, self::$FORBIDDEN_WORDS)){
                return $word;
            }

            return null;
        }, $words);

        return array_values(array_filter($validWord, function($item) {
            return ($item !== null);
        }));
    }

    /**
     * @param array $words
     * @return array
     */
    protected function markOneLetterAbbreviations($words)
    {
        return array_map(function($word){
            if(preg_match("/^([^.])\\./", $word)){
                $word = preg_replace("/^([^.])\\./", "$1AABBRREEVVIIAATTIIOONN", $word);

                while(preg_match("/\\w([^.])\\./", $word)){
                    $word = preg_replace("/(\\w[^.])\\./", "$1AABBRREEVVIIAATTIIOONN", $word);
                }
            }

            return $word;
        }, $words);
    }

    /**
     * @param array $words
     * @return array
     */
    protected function expandSpecialCharactersInSingletonWord($words)
    {
        $words = array_map(function($word){
            if(strlen($word) === 1){
                foreach (self::$SPECIAL_CHARACTERS_IN_SINGLETON_WORD as $character => $expanded){
                    if(preg_match("/" . $character . "/", $word)){
                        return explode(" ", $expanded);
                    }
                }
            }

            return $word;
        }, $words);

        return StringUtils::array_flatten($words, array());
    }

    /**
     * @param array $words
     * @return array
     */
    protected function ignoreSpecialCharactersInWords($words)
    {
        return array_map(function($word){
            return preg_replace("/(.+?)[@´%#!.$\"-\\/+\\(\\)](.+?)/", "$1$2", $word);
        }, $words);
    }

    /**
     * @param array $words
     * @return array
     */
    protected function splitOneLetterAbbreviations($words)
    {
        $abbreviations = array_map(function($word){
            if(preg_match("(AABBRREEVVIIAATTIIOONN)", $word)){
                return preg_split("/(AABBRREEVVIIAATTIIOONN)/", $word);
            }

            return $word;
        }, $words);

        return array_values(array_filter(StringUtils::array_flatten($abbreviations, array()), function($item){
            return !empty($item);
        }));
    }

    /**
     * @param array $words
     * @return array
     */
    protected function expandArabicNumerals($words)
    {
        $words = array_map(function($word) {
            if(preg_match("/[0-9]+/", $word)){
                $number = $this->normalize(SpanishNumbers::cardinal($word));
                return explode(" ", $number);
            }

            return $word;
        }, $words);

        return array_values(array_filter(StringUtils::array_flatten($words, array()), function($item){
            return !empty($item);
        }));
    }

    /**
     * @param array $words
     * @return array
     */
    protected function expandRomanNumerals($words)
    {
        $words = array_map(function($word) {
            if(RomanNumerals::isRomanNumeral($word)){
                $number = $this->normalize(SpanishNumbers::cardinal(RomanNumerals::parseInt($word)));
                return explode(" ", $number);
            }

            return $word;
        }, $words);

        return StringUtils::array_flatten($words, array());
    }

    /**
     * @return string
     */
    public function threeDigitsCode()
    {
        if(count($this->words) >= 3){
            return  sprintf("%s%s%s",
                $this->firstLetterOf($this->words[0]),
                $this->firstLetterOf($this->words[1]),
                $this->firstLetterOf($this->words[2]));
        } else if(count($this->words) == 2) {
            return sprintf("%s%s",
                $this->firstLetterOf($this->words[0]),
                $this->firstTwoLettersOf($this->words[1]));
        } else {
            return $this->firstThreeCharactersWithRightPad($this->words[0]);
        }
    }

    /**
     * @param string $word
     * @return string
     */
    protected function firstThreeCharactersWithRightPad($word)
    {
        if(strlen($word) >= 3){
            return substr($word, 0, 3);
        } else{
            return str_pad($word, 3, "X", STR_PAD_RIGHT);
        }
    }

    /**
     * @return string
     */
    public function birthdayCode(){
        return sprintf("%s%s%s",
            $this->lastTwoDigitsOf($this->person->year),
            $this->formattedInTwoDigits($this->person->month),
            $this->formattedInTwoDigits($this->person->day));
    }

    /**
     * @param string $word
     * @return string
     */
    protected function firstLetterOf($word){
        return substr($word, 0, 1);
    }

    /**
     * @param string $word
     * @return string
     */
    protected function firstTwoLettersOf($word){
        return substr($word, 0, 2);
    }

    /**
     * @param int $number YYYY
     * @return string
     */
    protected function lastTwoDigitsOf($number)
    {
        return $this->formattedInTwoDigits($number % 100);
    }

    /**
     * @param int $number
     * @return string
     */
    protected function formattedInTwoDigits($number)
    {
        return sprintf('%02d', $number);
    }
}