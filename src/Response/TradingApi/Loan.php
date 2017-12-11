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
 * Class Loan
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Loan extends AbstractResponse
{
    use DateTrait;

    /**
     * Example: 75073
     *
     * @var int
     */
    public $id;

    /**
     * Example: 0.00020000
     *
     * @var float
     */
    public $rate;

    /**
     * Example: 0.72234880
     *
     * @var float
     */
    public $amount;

    /**
     * Example: 2
     *
     * @var int
     */
    public $duration;

    /**
     * Available only for provided loans
     *
     * @var bool
     */
    public $autoRenew;

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
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @internal
     * @param bool $autoRenew
     */
    public function setAutoRenew(bool $autoRenew): void
    {
        $this->autoRenew = $autoRenew;
    }
}