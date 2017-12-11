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

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;

/**
 * Class ChartData
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class ChartData extends AbstractResponse
{
    /**
     * Example: 1511032200
     *
     * @var int
     */
    public $date;

    /**
     * Example: 0.01702169
     *
     * @var float
     */
    public $high;

    /**
     * Example: 0.01687201
     *
     * @var float
     */
    public $low;

    /**
     * Example: 0.016912
     *
     * @var float
     */
    public $open;

    /**
     * Example: 0.01699755
     *
     * @var float
     */
    public $close;

    /**
     * Example: 5.33183643
     *
     * @var float
     */
    public $volume;

    /**
     * Example: 314.01492203
     *
     * @var float
     */
    public $quoteVolume;

    /**
     * Example: 0.01697956
     *
     * @var float
     */
    public $weightedAverage;

    /**
     * @internal
     * @param int $date
     */
    public function setDate(int $date): void
    {
        $this->date = $date;
    }

    /**
     * @internal
     * @param float $high
     */
    public function setHigh(float $high): void
    {
        $this->high = $high;
    }

    /**
     * @internal
     * @param float $low
     */
    public function setLow(float $low): void
    {
        $this->low = $low;
    }

    /**
     * @internal
     * @param float $open
     */
    public function setOpen(float $open): void
    {
        $this->open = $open;
    }

    /**
     * @internal
     * @param float $close
     */
    public function setClose(float $close): void
    {
        $this->close = $close;
    }

    /**
     * @internal
     * @param float $volume
     */
    public function setVolume(float $volume): void
    {
        $this->volume = $volume;
    }

    /**
     * @internal
     * @param float $quoteVolume
     */
    public function setQuoteVolume(float $quoteVolume): void
    {
        $this->quoteVolume = $quoteVolume;
    }

    /**
     * @internal
     * @param float $weightedAverage
     */
    public function setWeightedAverage(float $weightedAverage): void
    {
        $this->weightedAverage = $weightedAverage;
    }
}