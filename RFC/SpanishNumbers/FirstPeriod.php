<?php

namespace RFC\SpanishNumbers;


class FirstPeriod
{
    private static $UNIT = ["cero", "uno", "dos", "tres", "cuatro", "cinco", "seis", "siete", "ocho", "nueve"];
    private static $TENS = ["diez", "veinte", "treinta", "cuarenta", "cincuenta", "sesenta", "setenta", "ochenta", "noventa"];
    private static $CENTS = ["ciento", "doscientos", "trescientos", "cuatrocientos", "quinientos", "seiscientos", "setecientos", "ochocientos", "novecientos"];
    private static $TWO_DIGITS_CARDINAL_11_TO_29 = ["once", "doce", "trece", "catorce", "quince", "dieciséis", "diecisiete", "dieciocho", "diecinueve"];
    private static $TWENTIES = ["veintiuno", "veintidós", "veintitrés", "veinticuatro", "veinticinco", "veintiséis", "veintisiete", "veintiocho", "veintinueve"];

    /**
     * @var int
     */
    private $periodSize;
    /**
     * @var int
     */
    protected $units;
    /**
     * @var int
     */
    protected $tens;
    /**
     * @var int
     */
    protected $cents;

    /**
     * FirstPeriod constructor.
     * @param int $number
     * @param int $periodSize
     */
    public function __construct($number, $periodSize)
    {

        $this->periodSize = $periodSize;

        $this->units = $number  % 10;
        $this->tens =  ($number / 10) % 10;
        $this->cents = ($number / 100) % 10;
    }

    /**
     * @return string
     */
    public function format(){
        return $this->formatCents() . $this->formatTens() . $this->formatUnits();
    }

    /**
     * @return string
     */
    private function formatCents() {
        if($this->cents === 0){
            return "";
        } elseif($this->cents === 1 && $this->tens === 0 && $this->units === 0) {
            return "cien";
        } else {
            return sprintf("%s%s", self::$CENTS[$this->cents - 1], ($this->tens !== 0 || $this->units !== 0) ? " " : "");
        }
    }

    /**
     * @return mixed|string
     */
    private function formatTens() {
        if($this->tens === 0) {
            return "";
        } elseif($this->units === 0) {
            return self::$TENS[$this->tens - 1];
        } elseif($this->tens === 1) {
            return self::$TWO_DIGITS_CARDINAL_11_TO_29[$this->units - 1];
        } elseif($this->tens === 2) {
            return self::$TWENTIES[$this->units - 1];
        } else {
            return self::$TENS[$this->tens - 1] . " y ";
        }
    }

    private function formatUnits() {
        if($this->tens === 1 || $this->tens === 2) {
            return "";
        } elseif(($this->tens !== 0 || $this->cents !== 0) && $this->units === 0) {
            return "";
        } elseif($this->periodSize >= 1 && $this->units === 0){
            return "";
        } else {
            return self::$UNIT[$this->units];
        }
    }
}