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

use Poloniex\Exception\PoloniexException;
use Poloniex\Response\{AbstractResponse, Traits\DateTrait};

/**
 * Class TradeHistory
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradeHistory extends AbstractResponse
{
    use DateTrait;

    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    private const TYPES = [
        self::TYPE_SELL,
        self::TYPE_BUY,
    ];

    /**
     * Global trade id
     * Example: 263017215
     *
     * @var int
     */
    public $globalTradeId;

    /**
     * Trade id
     * Example: 2909947
     *
     * @var int
     */
    public $tradeId;

    /**
     * Example: "sell" or "buy"
     *
     * @var string
     */
    public $type;

    /**
     * Example: "0.00000887"
     *
     * @var float
     */
    public $rate;

    /**
     * Example: "2565.84864449"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: "0.02275907"
     *
     * @var float
     */
    public $total;

    /**
     * @internal
     * @param string $type
     * @throws PoloniexException
     */
    public function setType(string $type): void
    {
        if (!\in_array($type, self::TYPES, true)) {
            throw new PoloniexException(sprintf('Invalid type %s given', $type));
        }

        $this->type = $type;
    }

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
}