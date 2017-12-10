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

namespace Poloniex\Response\TradingApi;

use Poloniex\Response\{AbstractResponse, Traits\DateTrait};

/**
 * Class OrderTrade
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class OrderTrade extends AbstractResponse
{
    use DateTrait;

    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    public const TYPES = [
        self::TYPE_SELL,
        self::TYPE_BUY,
    ];

    /**
     * Example: 20825863
     *
     * @var int
     */
    public $globalTradeId;

    /**
     * Example: 147142
     *
     * @var int
     */
    public $tradeId;

    /**
     * Example: "BTC_XVC"
     *
     * @var string
     */
    public $currencyPair;

    /**
     * Example: "buy"
     *
     * @var string
     */
    public $type;

    /**
     * Example: "0.00018500"
     *
     * @var float
     */
    public $rate;

    /**
     * Example: "455.34206390"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: "0.08423828"
     *
     * @var float
     */
    public $total;

    /**
     * Example: "0.00200000"
     *
     * @var float
     */
    public $fee;

    /**
     * @internal
     * @param int $globalTradeId
     */
    public function setGlobalTradeId(int $globalTradeId): void
    {
        $this->globalTradeId = $globalTradeId;
    }

    /**
     * @internal
     * @param int $tradeId
     */
    public function setTradeId(int $tradeId): void
    {
        $this->tradeId = $tradeId;
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
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @internal
     * @param float $fee
     */
    public function setFee(float $fee): void
    {
        $this->fee = $fee;
    }
}