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
 * Class ActiveLoans
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class ActiveLoans extends AbstractResponse
{
    /**
     * @var Loan[]
     */
    public $provided = [];

    /**
     * @var Loan[]
     */
    public $used = [];

    /**
     * @internal
     * @param Loan[] $provided
     */
    public function setProvided(array $provided)
    {
        $this->provided = $provided;
    }

    /**
     * @internal
     * @param Loan $loan
     */
    public function addProvided(Loan $loan)
    {
        $this->provided[] = $loan;
    }

    /**
     * @internal
     * @param Loan[] $used
     */
    public function setUsed(array $used)
    {
        $this->used = $used;
    }

    /**
     * @internal
     * @param Loan $loan
     */
    public function addUsed(Loan $loan)
    {
        $this->used[] = $loan;
    }
}