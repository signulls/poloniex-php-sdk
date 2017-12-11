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

namespace Poloniex\Response;

/**
 * Interface ResponseInterface
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
interface ResponseInterface
{
    /**
     * Common format for date fields
     */
    public const DATE_FORMAT = 'Y-m-d H:i:s';

    /**
     * Check whether response is failed
     *
     * @return bool
     */
    public function isFailed(): bool;
}