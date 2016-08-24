<?php

namespace RFC;


class Rfc
{
    /**
     * @var string
     */
    private $tenDigitsCode;
    /**
     * @var string
     */
    private $homoclave;
    /**
     * @var string
     */
    private $verificationDigit;

    /**
     * Rfc constructor.
     * @param string $tenDigitsCode
     * @param string $homoclave
     * @param string $verificationDigit
     */
    public function __construct($tenDigitsCode, $homoclave, $verificationDigit)
    {
        $this->tenDigitsCode = $tenDigitsCode;
        $this->homoclave = $homoclave;
        $this->verificationDigit = $verificationDigit;
    }

    public function toString(){
        return $this->tenDigitsCode . $this->homoclave . $this->verificationDigit;
    }
}