<?php
/**
 * This file is part of Poloniex PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2017-2018 Chasovskih Grisha <chasovskihgrisha@gmail.com>
 * @license https://github.com/signulls/poloniex-php-sdk/blob/master/LICENSE MIT
 */

namespace Poloniex\Response\TradingApi;

use Poloniex\Response\AbstractResponse;
use DateTime;

/**
 * Class LandingHistory
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class LandingHistory extends AbstractResponse
{
    /**
     * Example: 175589553
     *
     * @var int
     */
    public $id;

    /**
     * Example: "BTC"
     *
     * @var string
     */
    public $currency;

    /**
     * Example: 0.00057400
     *
     * @var float
     */
    public $rate;

    /**
     * Example: 0.04374404
     *
     * @var float
     */
    public $amount;

    /**
     * Example: 0.47610000
     *
     * @var float
     */
    public $duration;

    /**
     * Example: 0.00001196
     *
     * @var float
     */
    public $interest;

    /**
     * Example: -0.00000179
     *
     * @var float
     */
    public $fee;

    /**
     * Example: 0.00001017
     *
     * @var float
     */
    public $earned;

    /**
     * Example: 2016-09-28 06:47:26
     *
     * @var string
     */
    public $open;

    /**
     * Example: 2016-09-28 18:13:03
     *
     * @var string
     */
    public $close;

    /**
     * @internal
     * @param string|null $format
     * @return string
     */
    public function getOpen(string $format = null): string
    {
        return $format
            ? DateTime::createFromFormat(self::DATE_FORMAT, $this->open)->format($format)
            : $this->open;
    }

    /**
     * @param string $format
     * @return string
     */
    public function getClose(string $format = null): string
    {
        return $format
            ? DateTime::createFromFormat(self::DATE_FORMAT, $this->close)->format($format)
            : $this->close;
    }

    /**
     * @internal
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @internal
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @internal
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @internal
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @internal
     * @param float $duration
     */
    public function setDuration(float $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @internal
     * @param float $interest
     */
    public function setInterest(float $interest): void
    {
        $this->interest = $interest;
    }

    /**
     * @internal
     * @param float $fee
     */
    public function setFee(float $fee): void
    {
        $this->fee = $fee;
    }

    /**
     * @internal
     * @param float $earned
     */
    public function setEarned(float $earned): void
    {
        $this->earned = $earned;
    }
}