<?php

namespace RFC;


class JuristicPerson
{
    /**
     * @var string
     */
    private $legalName;
    /**
     * @var int
     */
    private $day;
    /**
     * @var int
     */
    private $month;
    /**
     * @var int
     */
    private $year;

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