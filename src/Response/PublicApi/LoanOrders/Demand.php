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

namespace Poloniex\Response\PublicApi\LoanOrders;

class Demand
{
    /**
     * Example: "0.02000000"
     *
     * @var string
     */
    public $rate;

    /**
     * Example: "0.00000171"
     *
     * @var string
     */
    public $amount;

    /**
     * Example: 2
     *
     * @var int
     */
    public $rangeMin;

    /**
     * Example: 2
     *
     * @var int
     */
    public $rangeMax;
}