<?php

namespace Poloniex\Response\Traits;

use DateTime;

/**
 * Trait DateTrait
 *
 * @package Poloniex\Exchange\Poloniex\Response
 */
trait DateTrait
{
    /**
     * Example: "2014-10-18 23:03:21"
     *
     * @var DateTime
     */
    public $date;

    /**
     * @internal
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = DateTime::createFromFormat('Y-m-d H:i:s', $date);
    }

    /**
     * @internal
     * @return DateTime
     */
    public function getDate(): DateTime
    {
        return $this->date;
    }
}