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

use Poloniex\Response\AbstractResponse;

/**
 * Class OpenOrder
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class OpenOrder extends AbstractResponse
{
    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    public const TYPES = [
        self::TYPE_SELL,
        self::TYPE_BUY,
    ];

    /**
     * Example: 216145914837
     *
     * @var int
     */
    public $orderNumber;

    /**
     * Example: "sell"
     *
     * @var string
     */
    public $type;

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
    public $startingAmount;

    /**
     * Example: "0.04975764"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: "0.00114442"
     *
     * @var float
     */
    public $total;

    /**
     * Example: 0
     *
     * @var int
     */
    public $margin;

    /**
     * @internal
     * @param int $orderNumber
     */
    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * @internal
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
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
     * @param float $startingAmount
     */
    public function setStartingAmount(float $startingAmount): void
    {
        $this->startingAmount = $startingAmount;
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
     * @param int $margin
     */
    public function setMargin(int $margin): void
    {
        $this->margin = $margin;
    }
}