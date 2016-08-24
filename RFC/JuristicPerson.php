<?php

namespace RFC;


class JuristicPerson implements HomoclavePerson
{
    /**
     * @var string
     */
    public $legalName;
    /**
     * @var int
     */
    public $day;
    /**
     * @var int
     */
    public $month;
    /**
     * @var int
     */
    public $year;

    /**
     * JuristicPerson constructor.
     * @param string  $legalName
     * @param int $day
     * @param int $month
     * @param int $year
     */
    public function __construct($legalName, $day, $month, $year)
    {
        $this->legalName = $legalName;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function getFullNameForHomoclave(){
        return $this->legalName;
    }
}