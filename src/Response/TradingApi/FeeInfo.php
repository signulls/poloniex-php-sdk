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

/**
 * Class FeeInfo
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class FeeInfo extends AbstractResponse
{
    /**
     * Example: 0.00140000
     *
     * @var float
     */
    public $makerFee;

    /**
     * Example: 0.00240000
     *
     * @var float
     */
    public $takerFee;

    /**
     * Example: 612.00248891
     *
     * @var float
     */
    public $thirtyDayVolume;

    /**
     * Example: 1200.00000000
     *
     * @var float
     */
    public $nextTier;

    /**
     * @internal
     * @param float $makerFee
     */
    public function setMakerFee(float $makerFee): void
    {
        $this->makerFee = $makerFee;
    }

    /**
     * @internal
     * @param float $takerFee
     */
    public function setTakerFee(float $takerFee): void
    {
        $this->takerFee = $takerFee;
    }

    /**
     * @internal
     * @param float $thirtyDayVolume
     */
    public function setThirtyDayVolume(float $thirtyDayVolume): void
    {
        $this->thirtyDayVolume = $thirtyDayVolume;
    }

    /**
     * @internal
     * @param float $nextTier
     */
    public function setNextTier(float $nextTier): void
    {
        $this->nextTier = $nextTier;
    }
}