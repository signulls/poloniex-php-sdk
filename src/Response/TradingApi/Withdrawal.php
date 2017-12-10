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
 * Class Withdrawal
 *
 * @@author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Withdrawal extends AbstractResponse
{
    /**
     * Example: 134933
     *
     * @var int
     */
    public $withdrawalNumber;

    /**
     * Example: "BTC"
     *
     * @var string
     */
    public $currency;

    /**
     * Example: "7N2i5n3DwTGzUq5Vmn7TUL9J3vdr1XBDFg"
     *
     * @var string
     */
    public $address;

    /**
     * Example: "5.00010000"
     *
     * @var float
     */
    public $amount;

    /**
     * Example: 1399267904
     *
     * @var int
     */
    public $timestamp;

    /**
     * Example: COMPLETE: 36e483efa6ayf9fd53t235177534d98451c4eb237c210e86cd2b9a2d4a988f8e
     *
     * @var string
     */
    public $status;

    /**
     * Example: "..."
     *
     * @var string
     */
    public $ipAddress;

    /**
     * @internal
     * @param int $withdrawalNumber
     */
    public function setWithdrawalNumber(int $withdrawalNumber): void
    {
        $this->withdrawalNumber = $withdrawalNumber;
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
     * @param int $timestamp
     */
    public function setTimestamp(int $timestamp): void
    {
        $this->timestamp = $timestamp;
    }
}