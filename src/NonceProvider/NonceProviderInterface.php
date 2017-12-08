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

namespace Poloniex\NonceProvider;

use Poloniex\ApiKey;

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