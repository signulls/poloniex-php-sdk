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
use Poloniex\Response\Traits\DateTrait;

/**
 * Class OrderStatus
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class OrderStatus extends AbstractResponse
{
    public const STATUS_OPEN = 'Open';
    public const STATUS_PARTIALLY_FILLED = 'Partially filled';

    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    use DateTrait;

    /**
     * Example: "Open" or "Partially filled"
     *
     * @var string
     */
    public $status;

    /**
     * Example: "0.02300000"
     *
     * @var float
     */
    public $rate;

    /**
     * Example: "0.04975764"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: "BTC_ETH"
     *
     * @var string
     */
    public $currencyPair;

    /**
     * Example: "0.00114442"
     *
     * @var float
     */
    public $total;

    /**
     * Example: "sell"
     *
     * @var string
     */
    public $type;

    /**
     * Example: "0.04975764"
     *
     * @var float
     */
    public $startingAmount;

    /**
     * @param float $amount
     */
    public function setAmount(float $amount): void
    {
        $this->amount = $amount;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    /**
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @param float $startingAmount
     */
    public function setStartingAmount(float $startingAmount): void
    {
        $this->startingAmount = $startingAmount;
    }
}