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

use Poloniex\Response\SampleResponse;

/**
 * Class MarginTrade
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class MarginTrade extends SampleResponse
{
    /**
     * Example: 154407998
     *
     * @var int
     */
    public $orderNumber;

    /**
     * NOTE: Keys of this array are currency pairs like "BTC_DASH"
     *
     * @var ResultingTrade[][]
     */
    public $resultingTrades = [];

    /**
     * @internal
     * @return ResultingTrade[][]
     */
    public function getResultingTrades(): array
    {
        return $this->resultingTrades;
    }

    /**
     * @internal
     * @param ResultingTrade[][] $resultingTrades
     */
    public function setResultingTrades(array $resultingTrades): void
    {
        $this->resultingTrades = $resultingTrades;
    }
}