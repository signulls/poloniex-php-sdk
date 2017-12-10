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

/**
 * Class TimeDependedNonceProvider
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TimeDependedNonceProvider implements NonceProviderInterface
{
    /**
     * Generate a nonce to avoid problems with 32bit systems
     *
     * {@inheritdoc}
     */
    public function get(ApiKey $apiKey): int
    {
        $time = explode(' ', microtime());

        return $time[1] . substr($time[0], 2, 6);
    }
}