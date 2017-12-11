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
 * Class MarginPosition
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class MarginPosition extends AbstractResponse
{
    public const TYPE_LONG = 'long';
    public const TYPE_NONE = 'none';

    /**
     * Example: 40.94717831
     *
     * @var float
     */
    public $amount;

    /**
     * Example: -0.09671314
     *
     * @var float
     */
    public $total;

    /**
     * Example: 0.00236190
     *
     * @var float
     */
    public $basePrice;

    /**
     * Example: -1
     *
     * @var int
     */
    public $liquidationPrice;

    /**
     * Example: -0.00058655
     *
     * @var float
     */
    public $pl;

    /**
     * Example: -0.00000038
     *
     * @var float
     */
    public $lendingFees;

    /**
     * Example: long
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
     * @param float $total
     */
    public function setTotal(float $total): void
    {
        $this->total = $total;
    }

    /**
     * @internal
     * @param float $basePrice
     */
    public function setBasePrice(float $basePrice): void
    {
        $this->basePrice = $basePrice;
    }

    /**
     * @internal
     * @param int $liquidationPrice
     */
    public function setLiquidationPrice(int $liquidationPrice): void
    {
        $this->liquidationPrice = $liquidationPrice;
    }

    /**
     * @internal
     * @param float $pl
     */
    public function setPl(float $pl): void
    {
        $this->pl = $pl;
    }

    /**
     * @internal
     * @param float $lendingFees
     */
    public function setLendingFees(float $lendingFees): void
    {
        $this->lendingFees = $lendingFees;
    }

    /**
     * @internal
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}