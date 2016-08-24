<?php

namespace RFC;


class NaturalPerson implements HomoclavePerson
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $firstLastName;
    /**
     * @var string
     */
    public $secondLastName;
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
     * NaturalPerson constructor.
     * @param string $name
     * @param string $firstLastName
     * @param string $secondLastName
     * @param int $day
     * @param int $month
     * @param int $year
     */
    public function __construct($name, $firstLastName, $secondLastName, $day, $month, $year)
    {
        $this->name = $name;
        $this->firstLastName = $firstLastName;
        $this->secondLastName = $secondLastName;
        $this->day = $day;
        $this->month = $month;
        $this->year = $year;
    }

    public function getFullNameForHomoclave(){
        return sprintf("%s %s %s", $this->firstLastName, $this->secondLastName, $this->name);
    }
}