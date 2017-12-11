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

namespace Poloniex\CallHistory;

/**
 * Interface CallHistoryInterface
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
interface CallHistoryInterface
{
    /**
     * Please note that making more than 6 calls per second to the public API, or repeatedly and needlessly
     * fetching excessive amounts of data, can result in your IP being banned.
     */
    public const CALLS_PER_SECOND = 6;

    /**
     * Create history record
     */
    public function create(): void;

    /**
     * Check whether limit per second is increased
     *
     * @return bool
     */
    public function isIncreased(): bool;
}