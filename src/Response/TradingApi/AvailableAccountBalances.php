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
 * NOTE: Keys of all property arrays are currency codes
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class AvailableAccountBalances extends AbstractResponse
{
    /**
     * @var string[]
     */
    public $exchange;

    /**
     * @var string[]
     */
    public $margin;

    /**
     * @var string[]
     */
    public $lending;
}