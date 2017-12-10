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
 * Class CompleteBalance
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class CompleteBalance extends AbstractResponse
{
    /**
     * Example: "5.015"
     *
     * @var float
     */
    public $available;

    /**
     * Example: "1.0025"
     *
     * @var float
     */
    public $onOrders;

    /**
     * Example: "0.078"
     *
     * @var float
     */
    public $btcValue;

    /**
     * @internal
     * @param float $available
     */
    public function setAvailable(float $available): void
    {
        $this->available = $available;
    }

    /**
     * @internal
     * @param float $onOrders
     */
    public function setOnOrders(float $onOrders): void
    {
        $this->onOrders = $onOrders;
    }

    /**
     * @internal
     * @param float $btcValue
     */
    public function setBtcValue(float $btcValue): void
    {
        $this->btcValue = $btcValue;
    }
}