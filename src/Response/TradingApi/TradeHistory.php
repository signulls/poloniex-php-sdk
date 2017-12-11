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

use Poloniex\Response\{AbstractResponse, Traits\DateTrait};

/**
 * Class TradeHistory
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradeHistory extends AbstractResponse
{
    use DateTrait;

    public const CATEGORY_EXCHANGE = 'exchange';
    public const CATEGORY_SETTLEMENT = 'settlement';
    public const CATEGORY_MARGIN_TRADE = 'marginTrade';

    public const CATEGORIES = [
        self::CATEGORY_EXCHANGE,
        self::CATEGORY_SETTLEMENT,
        self::CATEGORY_MARGIN_TRADE,
    ];

    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    public const TYPES = [
        self::TYPE_SELL,
        self::TYPE_BUY,
    ];

    /**
     * Example: 264105095
     *
     * @var int
     */
    public $globalTradeId;

    /**
     * Example: 2376559
     *
     * @var int
     */
    public $tradeId;

    /**
     * Example: "0.23500000"
     *
     * @var float
     */
    public $rate;

    /**
     * Example: "46.81623294"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: "11.00181474"
     *
     * @var float
     */
    public $total;

    /**
     * Example: "0.00150000"
     *
     * @var float
     */
    public $fee;

    /**
     * Example: "64218702142"
     *
     * @var int
     */
    public $orderNumber;

    /**
     * Example: "sell" or "buy"
     *
     * @var string
     */
    public $type;

    /**
     * Example: "exchange"
     *
     * @var string
     */
    public $category;

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

    /**
     * @internal
     * @param int $orderNumber
     */
    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }
}