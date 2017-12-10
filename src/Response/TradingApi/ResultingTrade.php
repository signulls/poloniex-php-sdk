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
 * Class ResultingTrade
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class ResultingTrade extends AbstractResponse
{
    use DateTrait;

    /**
     * Example: "338.8732"
     *
     * @var string
     */
    public $amount;

    /**
     * Example: "0.00000173"
     *
     * @var float
     */
    public $rate;

    /**
     * Example: 0.00058625
     *
     * @var float
     */
    public $total;

    /**
     * Example: 16164
     *
     * @var int
     */
    public $tradeId;

    /**
     * Example: "buy" or "sell"
     *
     * @var string
     */
    public $type;

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
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
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