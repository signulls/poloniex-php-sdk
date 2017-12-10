<?php
/**
 * This file is part of Poloniex PHP SDK.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @copyright 2017-2018 Chasovskih Grisha <chasovskihgrisha@gmail.com>
 * @license   http://www.opensource.org/licenses/mit-license.php MIT
 */

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;

/**
 * Class Ticker
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Ticker extends AbstractResponse
{
    /**
     * Example: BTC_ETH
     *
     * @var string
     */
    public $pair;

    /**
     * Example: 8
     *
     * @var int
     */
    public $id;

    /**
     * Example: "0.00001356"
     *
     * @var float
     */
    public $last;

    /**
     * "0.00001359"
     *
     * @var float
     */
    public $lowestAsk;

    /**
     * "0.00001356"
     *
     * @var float
     */
    public $highestBid;

    /**
     * "-0.05373342"
     *
     * @var float
     */
    public $percentChange;

    /**
     * "5.68453100"
     *
     * @var float
     */
    public $baseVolume;

    /**
     * "401407.79462359"
     *
     * @var float
     */
    public $quoteVolume;

    /**
     * @var bool
     */
    public $isFrozen;

    /**
     * "0.00001495"
     *
     * @var float
     */
    public $high24hr;

    /**
     * "0.00001356"
     *
     * @var float
     */
    public $low24hr;

    /**
     * @internal
     * @param string $pair
     */
    public function setPair(string $pair): void
    {
        $this->pair = $pair;
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
     * @param float $last
     */
    public function setLast(float $last): void
    {
        $this->last = $last;
    }

    /**
     * @internal
     * @param float $lowestAsk
     */
    public function setLowestAsk(float $lowestAsk): void
    {
        $this->lowestAsk = $lowestAsk;
    }

    /**
     * @internal
     * @param float $highestBid
     */
    public function setHighestBid(float $highestBid): void
    {
        $this->highestBid = $highestBid;
    }

    /**
     * @internal
     * @param float $percentChange
     */
    public function setPercentChange(float $percentChange): void
    {
        $this->percentChange = $percentChange;
    }

    /**
     * @internal
     * @param float $baseVolume
     */
    public function setBaseVolume(float $baseVolume): void
    {
        $this->baseVolume = $baseVolume;
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
     * @param bool $isFrozen
     */
    public function setIsFrozen(bool $isFrozen): void
    {
        $this->isFrozen = $isFrozen;
    }

    /**
     * @internal
     * @param float $high24hr
     */
    public function setHigh24hr(float $high24hr): void
    {
        $this->high24hr = $high24hr;
    }

    /**
     * @internal
     * @param float $low24hr
     */
    public function setLow24hr(float $low24hr): void
    {
        $this->low24hr = $low24hr;
    }
}