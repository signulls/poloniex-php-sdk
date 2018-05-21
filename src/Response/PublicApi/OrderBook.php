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

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;

/**
 * Class OrderBook
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class OrderBook extends AbstractResponse
{
    /**
     * Example:
     *
     * ...
     *  [
     *      0.00000894,
     *      22.3714
     *  ],
     *  [
     *      0.00000895,
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
     * Example: 52954955
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

    /**
     * @internal
     * @param int $seq
     */
    public function setSeq(int $seq): void
    {
        $this->seq = $seq;
    }
}