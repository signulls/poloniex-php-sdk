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
 * Class DepositAddresses
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class DepositAddresses extends AbstractResponse
{
    /**
     * Keys are 3-digit coin codes
     *
     * @var string[]
     */
    public $addresses = [];
}