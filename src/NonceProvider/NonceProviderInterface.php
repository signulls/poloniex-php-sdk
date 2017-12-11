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

namespace Poloniex\NonceProvider;

use Poloniex\ApiKey;

/**
 * Interface NonceProviderInterface
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
interface NonceProviderInterface
{
    /**
     * The nonce parameter is an integer which must always be greater than the previous nonce used.
     *
     * @param ApiKey $apiKey
     * @return int
     */
    public function get(ApiKey $apiKey): int;
}