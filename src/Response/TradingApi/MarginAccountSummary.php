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
 * Class MarginAccountSummary
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class MarginAccountSummary extends AbstractResponse
{
    /**
     * Example: "0.00346561"
     *
     * @var float
     */
    public $totalValue;

    /**
     * Example: "-0.00001220"
     *
     * @var float
     */
    public $pl;

    /**
     * Example: "0.00000000"
     *
     * @var float
     */
    public $lendingFees;

    /**
     * Example: "0.00345341"
     *
     * @var float
     */
    public $netValue;

    /**
     * Example: "0.00123220"
     *
     * @var float
     */
    public $totalBorrowedValue;

    /**
     * Example: "2.80263755"
     *
     * @var float
     */
    public $currentMargin;

    /**
     * @internal
     * @param float $totalValue
     */
    public function setTotalValue(float $totalValue): void
    {
        $this->totalValue = $totalValue;
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
     * @param float $netValue
     */
    public function setNetValue(float $netValue): void
    {
        $this->netValue = $netValue;
    }

    /**
     * @internal
     * @param float $totalBorrowedValue
     */
    public function setTotalBorrowedValue(float $totalBorrowedValue): void
    {
        $this->totalBorrowedValue = $totalBorrowedValue;
    }

    /**
     * @internal
     * @param float $currentMargin
     */
    public function setCurrentMargin(float $currentMargin): void
    {
        $this->currentMargin = $currentMargin;
    }
}