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

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;

class Ticker extends AbstractResponse
{
    /**
     * Example: BTC_ETH
     *
     * @var string
     */
    public $pair;

    /**
     * Example: 8
     *
     * @var int
     */
    public $id;

    /**
     * Example: "0.00001356"
     *
     * @var
     */
    public $last;

    /**
     * "0.00001359"
     *
     * @var string
     */
    public $lowestAsk;

    /**
     * "0.00001356"
     *
     * @var string
     */
    public $highestBid;

    /**
     * "-0.05373342"
     *
     * @var string
     */
    public $percentChange;

    /**
     * "5.68453100"
     *
     * @var string
     */
    public $baseVolume;

    /**
     * "401407.79462359"
     *
     * @var string
     */
    public $quoteVolume;

    /**
     * @var string
     */
    public $isFrozen;

    /**
     * "0.00001495"
     *
     * @var string
     */
    public $high24hr;

    /**
     * "0.00001356"
     *
     * @var string
     */
    public $low24hr;
}