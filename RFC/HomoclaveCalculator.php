<?php

namespace RFC;


class HomoclaveCalculator
{
    /**
     * @var HomoclavePerson
     */
    protected $person;
    /**
     * @var string
     */
    protected $HOMOCLAVE_DIGITS = "123456789ABCDEFGHIJKLMNPQRSTUVWXYZ";
    /**
     * @var array
     */
    protected $FULL_NAME_MAPPING = [
        " " => "00",
        "0" => "00",
        "1" => "01",
        "2" => "02",
        "3" => "03",
        "4" => "04",
        "5" => "05",
        "6" => "06",
        "7" => "07",
        "8" => "08",
        "9" => "09",
        "&" => "10",
        "A" => "11",
        "B" => "12",
        "C" => "13",
        "D" => "14",
        "E" => "15",
        "F" => "16",
        "G" => "17",
        "H" => "18",
        "I" => "19",
        "J" => "21",
        "K" => "22",
        "L" => "23",
        "M" => "24",
        "N" => "25",
        "O" => "26",
        "P" => "27",
        "Q" => "28",
        "R" => "29",
        "S" => "32",
        "T" => "33",
        "U" => "34",
        "V" => "35",
        "W" => "36",
        "X" => "37",
        "Y" => "38",
        "Z" => "39",
        "^" => "40"
    ];
    /**
     * @var array
     */
    protected $invalidCharacters = [".", "'", ",", "-"];
    /**
     * @var string
     */
    protected $fullName;
    protected $mappedFullName = "0";
    protected $pairOfDigitsSum = 0;

    /**
     * HomoclaveCalculator constructor.
     * @param HomoclavePerson $person
     */
    public function __construct(HomoclavePerson $person)
    {
        $this->person = $person;
    }

    /**
     * @return string
     */
    public function calculate()
    {
        $this->normalizeFullName();
        $this->mapFullNameToDigitsCode();
        $this->sumPairOfDigits();
        return $this->buildHomoclave();
    }

    /**
     * @return string
     */
    public function buildHomoclave()
    {
        $lastThreeDigits = $this->pairOfDigitsSum % 1000;

        $quo = $lastThreeDigits / 34;
        $reminder = $lastThreeDigits % 34;

        return sprintf("%s%s", substr($this->HOMOCLAVE_DIGITS, $quo, 1), substr($this->HOMOCLAVE_DIGITS, $reminder, 1));
    }

    protected function sumPairOfDigits()
    {
        for($i = 0; $i < strlen($this->mappedFullName) - 1; $i++){
            $number1 = (int) substr($this->mappedFullName, $i, 2);
            $number2 = (int) substr($this->mappedFullName, $i + 1, 1);

            $this->pairOfDigitsSum += $number1 * $number2;
        }
    }

    protected function mapFullNameToDigitsCode()
    {
        array_map(function($character){
            if(!array_key_exists($character, $this->FULL_NAME_MAPPING)){
                throw new \InvalidArgumentException("No two-digit-code mapping for char: " . $character);
            }

            $this->mappedFullName = sprintf("%s%s", $this->mappedFullName, $this->FULL_NAME_MAPPING[$character]);

        }, str_split($this->fullName));
    }

    protected function normalizeFullName(){
        $rawFullName = strtoupper($this->person->getFullNameForHomoclave());

        $this->fullName = strtoupper(StringUtils::remove_accents($rawFullName));
        $this->removeInvalidCharacters();
        $this->addMissingCharToFullname();
    }

    protected function removeInvalidCharacters(){
        array_map(function($character){
            $this->fullName = str_replace($character, "", $this->fullName);
        }, $this->invalidCharacters);
    }

    protected function addMissingCharToFullname(){
        $rawFullName = $this->person->getFullNameForHomoclave();

        $index = strpos($rawFullName, "Ñ")
                 ? strpos($rawFullName, "Ñ") : strpos($rawFullName, "ñ");

        while($index){
            $this->fullName = substr_replace($this->fullName, '^', $index, 1);
            $index = strpos($rawFullName, $index + 1);
        }
    }
}