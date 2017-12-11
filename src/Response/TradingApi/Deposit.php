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

/**
 * Class Deposit
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class Deposit
{
    public const STATUS_COMPLETE = 'COMPLETE';

    /**
     * Example: "BTC"
     *
     * @var string
     */
    public $currency;

    /**
     * Example: "13WSidUvXrHjcDMKnGJmWm5UwVQey4i1LA"
     *
     * @var string
     */
    public $address;

    /**
     * Example: "0.00520713"
     *
     * @var string
     */
    public $amount;

    /**
     * Example: 1
     *
     * @var int
     */
    public $confirmations;

    /**
     * Example: "4e8c95271fe1eadb3a2cbce3c9ed30b9764816b3a86d9bb5fae7c323febdb6cb"
     *
     * @var string
     */
    public $txid;

    /**
     * Example: 1510252527
     *
     * @var int
     */
    public $timestamp;

    /**
     * Example: "COMPLETE"
     *
     * @var string
     */
    public $status;
}