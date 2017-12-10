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
 * Class MoveOrder
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class MoveOrder extends AbstractResponse
{
    /**
     * @var bool
     */
    public $success;

    /**
     * Example: 239574176
     *
     * @var int
     */
    public $orderNumber;

    /**
     * NOTE: Array keys are currency pairs
     *
     * @var ResultingTrade[]
     */
    public $resultingTrades;

    /**
     * @internal
     * @param bool $success
     */
    public function setSuccess(bool $success): void
    {
        $this->success = $success;
    }

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
     * @return ResultingTrade[]
     */
    public function getResultingTrades(): array
    {
        return $this->resultingTrades;
    }

    /**
     * @internal
     * @param ResultingTrade[] $resultingTrades
     */
    public function setResultingTrades(array $resultingTrades): void
    {
        $this->resultingTrades = $resultingTrades;
    }

    /**
     * @internal
     * @param ResultingTrade $resultingTrade
     */
    public function addResultingTrade(ResultingTrade $resultingTrade): void
    {
        $this->resultingTrades[] = $resultingTrade;
    }
}