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
    /**s
     * Please note that making more than 6 calls per second to the public API, or repeatedly and needlessly
     * fetching excessive amounts of data, can result in your IP being banned.
     */
    public const CALLS_PER_SECOND = 5;

    /**
     * Create history record
     *
     * @param string|null $proxy
     */
    public function create(string $proxy = null): void;

    /**
     * Check whether limit per second is increased
     *
     * @param string|null $proxy
     * @return bool
     */
    public function isIncreased(string $proxy = null): bool;
}