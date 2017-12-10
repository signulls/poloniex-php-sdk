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
 * Class TradeResult
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradeResult extends AbstractResponse
{
    /**
     * Example: 31226040
     *
     * @var int
     */
    public $orderNumber;

    /**
     * @var ResultingTrade[]
     */
    public $resultingTrades = [];

    /**
     * @internal
     * @param int $orderNumber
     */
    public function setOrderNumber(int $orderNumber): void
    {
        $this->orderNumber = $orderNumber;
    }
}