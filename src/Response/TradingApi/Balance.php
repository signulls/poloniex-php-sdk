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
 * Class Balance
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Balance extends AbstractResponse
{
    /**
     * Array keys are 3-digit currency codes
     * Values are equal totalValue - onOrders
     *
     * @var string[]
     */
    public $currencies = [];
}