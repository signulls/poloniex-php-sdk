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

class DayVolume extends AbstractResponse
{
    /**
     * Keys of array are keypair like ETH_BTC
     * Values looks like:
     *  [
     *      "ETH": "9.54678847",
     *      "BTC": "75427.64791175"
     *  ]
     *
     * @var array[]
     */
    public $volume = [];

    /**
     * NOTE: Keys of array are 3-digit currency code
     *
     * @var string[]
     */
    public $total = [];
}