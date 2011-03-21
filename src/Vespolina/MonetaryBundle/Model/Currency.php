<?php

namespace Vespolina\MonetaryBundle\Model;

interface CurrencyInterface
{
    /**
     * Get the ISO 4217 currency code of this currency.
     *
     * @return string
     */
    public function getCurrencyCode();

    /**
     * Get the symbol for the currency
     *
     * @return string
     */
    public function getSymbol();

    /**
     * Get the default number of fraction digits for the currency
     *
     * @return integer
     */
    public function getFractionalDigits();

    /**
     * Return the amount, formatted for the currency
     *
     * @param mixed $amount
     *
     * @return string
     */
    public function formatAmount($amount);

    /**
     * Return the exchange rate, based on base currency
     *
     * @return mixed $rate
     */
    public function getExchangeRate();

    /**
     * Return the date and time of the exchange rate
     *
     * @return \DateTime
     */
    public function getExchangeDateTime();

    /**
     * Return the base currency for the exchange rate
     *
     * @return Vespolina\MonetaryBundle\Model\CurrencyInterface
     */
    public function getBaseCurrency();

    /**
     * Return the value after the currency conversion, this can be an instance of
     * Vespolina\MonetaryBundle\Model\MonetaryInterface.  If a Monetary object is passed in as the amount
     * an new instance of Vespolina\MonetaryBundle\Model\MonetaryInterface, with this currency is returned
     *
     * @param mixed $amount
     * @return mixed
     */
    public function exchange($amount);
}
