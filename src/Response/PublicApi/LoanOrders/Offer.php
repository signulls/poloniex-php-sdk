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

namespace Poloniex\Response\PublicApi\LoanOrders;

/**
 * Class Offer
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Offer
{
    /**
     * Example: 0.00005885
     *
     * @var float
     */
    public $rate;

    /**
     * Example: 1.05657993
     *
     * @var string
     */
    public $amount;

    /**
     * Example: 2
     *
     * @var int
     */
    public $rangeMin;

    /**
     * Example: 2
     *
     * @var int
     */
    public $rangeMax;

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
     * @param int $rangeMin
     */
    public function setRangeMin(int $rangeMin): void
    {
        $this->rangeMin = $rangeMin;
    }

    /**
     * @internal
     * @param int $rangeMax
     */
    public function setRangeMax(int $rangeMax): void
    {
        $this->rangeMax = $rangeMax;
    }
}