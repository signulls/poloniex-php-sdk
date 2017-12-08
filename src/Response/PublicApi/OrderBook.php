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

class OrderBook extends AbstractResponse
{
    /**
     * Example:
     *
     * ...
     *  [
     *      "0.00000894",
     *      22.3714
     *  ],
     *  [
     *      "0.00000895",
     *      4263.07564651
     *  ],
     * ...
     *
     * @var array[]
     */
    public $asks = [];

    /**
     * Examlple:
     *
     * ...
     *  [
     *      "0.00000888",
     *      522.5225
     *  ],
     *  [
     *      "0.00000887",
     *      1381.66565476
     *  ],
     * ...
     *
     * @var array[]
     */
    public $bids = [];

    /**
     * @var bool
     */
    public $isFrozen;

    /**
     * Examlple: 52954955
     *
     * @var int
     */
    public $seq;

    /**
     * @internal
     * @param bool $isFrozen
     */
    public function setIsFrozen(bool $isFrozen): void
    {
        $this->isFrozen = $isFrozen;
    }
}