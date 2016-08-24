<?php

namespace RFC;


class RfcBuilder
{
    /**
     * @var string
     */
    protected $name;
    /**
     * @var string
     */
    protected $firstLastName;
    /**
     * @var string
     */
    protected $secondLastName;
    /**
     * @var string
     */
    protected $legalName;
    /**
     * @var int
     */
    protected $day;
    /**
     * @var int
     */
    protected $month;
    /**
     * @var int
     */
    protected $year;
    public $tenDigitsCode;
    public $homoclave;
    public $verificationDigit;

    /**
     * @param string $name
     * @return $this
     */
    public function name($name){
        $this->name = $name;
        return $this;
    }

    /**
     * @param string $firstLastName
     * @return $this
     */
    public function firstLastName($firstLastName){
        $this->firstLastName = $firstLastName;
        return $this;
    }

    /**
     * @param string $secondLastName
     * @return $this
     */
    public function secondLastName($secondLastName){
        $this->secondLastName = $secondLastName;
        return $this;
    }

    /**
     * @param int $day
     * @param int $month
     * @param int $year
     * @return $this
     */
    public function birthday($day, $month, $year){
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
        return $this;
    }

    /**
     * @param string $legalName
     * @return $this
     */
    public function legalName($legalName){
        $this->legalName = $legalName;
        return $this;
    }

    /**
     * @param int $day
     * @param int $month
     * @param int $year
     * @return RfcBuilder
     */
    public function creationDate($day, $month, $year){
        return $this->birthday($day, $month, $year);
    }

    /**
     * @return Rfc
     */
    public function build(){
        if($this->legalName !== null){
            return $this->buildForJuristicPerson();
        } else {
            return $this->buildForNaturalPerson();
        }
    }

    /**
     * @return Rfc
     */
    protected function buildForJuristicPerson(){
        $juristicPerson = new JuristicPerson($this->legalName, $this->day, $this->month, $this->year);

        $juristicPersonTenDigitsCode = new JuristicPersonTenDigitCalculator($juristicPerson);
        $this->tenDigitsCode = $juristicPersonTenDigitsCode->calculate();

        $homoclaveCalculator = new HomoclaveCalculator($juristicPerson);
        $this->homoclave = $homoclaveCalculator->calculate();

        $verificationDigit = new VerificationDigitCalculator(' ' . $this->tenDigitsCode . $this->homoclave);
        $this->verificationDigit = $verificationDigit->calculate();

        return new Rfc($this->tenDigitsCode, $this->homoclave, $this->verificationDigit);
    }

    /**
     * @return Rfc
     */
    protected function buildForNaturalPerson(){
        $naturalPerson = new NaturalPerson($this->name, $this->firstLastName, $this->secondLastName, $this->day, $this->month, $this->year);

        $naturalPersonPersonTenDigitsCode = new NaturalPersonTenDigitsCalculator($naturalPerson);
        $this->tenDigitsCode = $naturalPersonPersonTenDigitsCode->calculate();

        $homoclaveCalculator = new HomoclaveCalculator($naturalPerson);
        $this->homoclave = $homoclaveCalculator->calculate();

        $verificationDigit = new VerificationDigitCalculator($this->tenDigitsCode . $this->homoclave);
        $this->verificationDigit = $verificationDigit->calculate();

        return new Rfc($this->tenDigitsCode, $this->homoclave, $this->verificationDigit);
    }
}