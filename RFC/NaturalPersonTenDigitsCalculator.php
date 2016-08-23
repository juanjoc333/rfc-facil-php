<?php

namespace RFC;


use InvalidArgumentException;

class NaturalPersonTenDigitsCalculator
{
    /**
     * @var NaturalPerson
     */
    protected $person;

    protected static $vowelPattern = "/[AEIOU]+/";

    protected static $specialParticles = [
        "DE", "LA", "LAS", "MC", "VON", "DEL", "LOS", "Y", "MAC", "VAN", "MI"
    ];

    protected $forbiddenWords = [
            "BUEI", "BUEY", "CACA", "CACO", "CAGA", "KOGE", "KAKA", "MAME", "KOJO", "KULO",
            "CAGO", "COGE", "COJE", "COJO", "FETO", "JOTO", "KACO", "KAGO", "MAMO", "MEAR", "MEON",
            "MION", "MOCO", "MULA", "PEDA", "PEDO", "PENE", "PUTA", "PUTO", "QULO", "RATA", "RUIN"
    ];

    /**
     * NaturalPersonTenDigitsCalculator constructor.
     * @param NaturalPerson $person
     */
    public function __construct(NaturalPerson $person)
    {
        $this->person = $person;
    }

    /**
     * @param string $nameCode
     * @return string
     */
    protected function obfuscateForbiddenWords($nameCode){
        return (in_array($nameCode, $this->forbiddenWords))
            ? sprintf("%sX", substr($nameCode, 0, 3))
            : $nameCode;
    }

    /**
     * @return string
     */
    public function calculate(){
        return $this->obfuscateForbiddenWords($this->nameCode()) . $this->birthdayCode();
    }

    protected function nameCode(){
        if($this->isFirstLastNameEmpty()){
            return $this->firstLastNameEmptyForm();
        } elseif ($this->isSecondLastNameEmpty()){
            return $this->secondLastNameEmptyForm();
        } elseif($this->isFirstLastNameIsTooShort()){
            return $this->firstLastNameTooShortForm();
        } else {
            return $this->normalForm();
        }
    }

    /**
     * @return bool
     */
    protected function isFirstLastNameEmpty(){
        return empty($this->normalize($this->person->firstLastName));
    }

    /**
     * @return string
     */
    protected function firstLastNameEmptyForm(){
        return sprintf("%s%s",
            $this->firstTwoLettersOf($this->person->secondLastName),
            $this->firstTwoLettersOf($this->person->name));
    }

    /**
     * @return bool
     */
    protected function isSecondLastNameEmpty(){
        return empty($this->normalize($this->person->secondLastName));
    }

    /**
     * @return string
     */
    protected function secondLastNameEmptyForm(){
        return sprintf("%s%s",
            $this->firstTwoLettersOf($this->person->firstLastName),
            $this->firstTwoLettersOf($this->person->name));
    }

    /**
     * @return bool
     */
    protected function isFirstLastNameIsTooShort(){
        return (strlen($this->normalize($this->person->firstLastName)) <= 2) ? true : false;
    }

    /**
     * @return string
     */
    protected function firstLastNameTooShortForm()
    {
        return sprintf("%s%s%s",
            $this->firstLetterOf($this->person->firstLastName),
            $this->firstLetterOf($this->person->secondLastName),
            $this->firstTwoLettersOf($this->person->name));

    }

    /**
     * @return string
     */
    protected function normalForm()
    {
        return sprintf("%s%s%s%s",
            $this->firstLetterOf($this->person->firstLastName),
            $this->firstVowelExcludingFirstCharacterOf($this->person->firstLastName),
            $this->firstLetterOf($this->person->secondLastName),
            $this->firstLetterOf($this->filterName($this->person->name)));
    }

    /**
     * @param string $word
     * @return string
     */
    protected function firstTwoLettersOf($word){
        return substr($this->normalize($word), 0, 2);
    }

    /**
     * @param $word
     * @return string
     */
    protected function firstLetterOf($word){
        return substr($this->normalize($word), 0, 1);
    }

    /**
     * @param string $word
     * @return string
     */
    protected function normalize($word){
        if(empty($word)){
            return $word;
        } else {
            $word = strtoupper(StringUtils::remove_accents($word));
            return $this->removeSpecialParticles($word, self::$specialParticles);
        }
    }

    /**
     * @param string $word
     * @param array $specialParticle
     * @return string
     */
    protected function removeSpecialParticles($word, $specialParticle){
        foreach ($specialParticle as $particle){
            $particlePositions = [$particle . " ", " " . $particle];
            foreach ($particlePositions as $particlePosition){
                $word = str_replace($particlePosition, "", $word);
            }
        }

        return $word;
    }

    /**
     * @param string $word
     * @return string
     */
    protected function firstVowelExcludingFirstCharacterOf($word) {
        $normalizedWord = substr($this->normalize($word), 1);

        $matches = [];

        preg_match(self::$vowelPattern, $normalizedWord, $matches);

        if(!count($matches)){
            throw new InvalidArgumentException("Word doesn't contain a vowel: " . $normalizedWord);
        }

        return substr($matches[0], 0, 1);
    }

    /**
     * @param string $name
     * @return string
     */
    protected function filterName($name){
        $rawName = trim($this->normalize($name));

        if(preg_match("/\\s/", $rawName)){
            if(preg_match("/\\b(MARIA)\\b/", $rawName) || preg_match("/\\b(JOSE)\\b/", $rawName)){
                $names = explode(" ", $rawName);

                if($names[0] === "MARIA" || $names[0] === "JOSE"){
                    return $names[1];
                }

                return $names[0];
            }
        }

        return $name;
    }


    /**
     * @return string
     */
    protected function birthdayCode(){
        return sprintf("%s%s%s",
            $this->lastTwoDigitsOf($this->person->year),
            $this->formattedInTwoDigits($this->person->month),
            $this->formattedInTwoDigits($this->person->day));
    }

    /**
     * @param int $number YYYY
     * @return string
     */
    protected function lastTwoDigitsOf($number){
        return $this->formattedInTwoDigits($number % 100);
    }

    /**
     * @param int $number
     * @return string
     */
    protected function formattedInTwoDigits($number){
        return sprintf('%02d', $number);
    }
}