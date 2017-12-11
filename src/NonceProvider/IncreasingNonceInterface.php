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
 * Interface IncreasingNonceInterface
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
interface IncreasingNonceInterface
{
    /**
     * Increase nonce
     *
     * @param ApiKey $apiKey
     */
    public function increase(ApiKey $apiKey): void;
}