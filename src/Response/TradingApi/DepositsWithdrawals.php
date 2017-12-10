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
 * Class DepositsWithdrawals
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class DepositsWithdrawals extends AbstractResponse
{
    /**
     * @var Deposit[]
     */
    public $deposits = [];

    /**
     * @var Withdrawal[]
     */
    public $withdrawals = [];

    /**
     * @internal
     * @return Deposit[]
     */
    public function getDeposits(): array
    {
        return $this->deposits;
    }

    /**
     * @internal
     * @param Deposit $deposit
     */
    public function addDeposit(Deposit $deposit): void
    {
        $this->deposits[] = $deposit;
    }

    /**
     * @internal
     * @param Deposit[] $deposits
     */
    public function setDeposits(array $deposits): void
    {
        $this->deposits = $deposits;
    }

    /**
     * @internal
     * @return Withdrawal[]
     */
    public function getWithdrawals(): array
    {
        return $this->withdrawals;
    }

    /**
     * @internal
     * @param Withdrawal $withdrawal
     */
    public function addWithdrawal(Withdrawal $withdrawal): void
    {
        $this->withdrawals[] = $withdrawal;
    }

    /**
     * @internal
     * @param Withdrawal[] $withdrawals
     */
    public function setWithdrawals(array $withdrawals): void
    {
        $this->withdrawals = $withdrawals;
    }


}