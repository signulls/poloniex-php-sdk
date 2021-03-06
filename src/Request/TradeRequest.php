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

namespace Poloniex\Request;

/**
 * Class TradeRequest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradeRequest implements RequestInterface
{
    public const MIN_TOTAL = [
        'BTC' => 0.0001,
        'XMR' => 0.0001,
        'ETH' => 0.0001,
        'USDT' => 1,
        'USDC' => 1,
    ];

    /**
     * @var string
     */
    public $currencyPair;

    /**
     * @var string
     */
    public $rate;

    /**
     * @var float
     */
    public $amount;

    /**
     * A fill-or-kill order will either fill in its entirety or be completely aborted.
     *
     * @var int
     */
    public $fillOrKill = 0;

    /**
     * An immediate-or-cancel order can be partially or completely filled, but any portion of the
     * order that cannot be filled immediately will be canceled rather than left on the order book.
     *
     * @var int
     */
    public $immediateOrCancel = 0;

    /**
     * A post-only order will only be placed if no portion of it fills immediately; this guarantees
     * you will never pay the taker fee on any part of the order that fills.
     *
     * @var int
     */
    public $postOnly = 0;
}