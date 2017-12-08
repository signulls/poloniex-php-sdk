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

namespace Poloniex;

/**
 * Class ApiKey
 *
 * To create new API keys please refer to the https://poloniex.com/apiKeys
 */
class ApiKey
{
    /**
     * Your API key
     *
     * @var string
     */
    private $apiKey;

    /**
     * The query's POST data signed by your key's "secret" according to the HMAC-SHA512 method.
     *
     * @var string
     */
    private $secret;

    /**
     * ApiKey constructor.
     *
     * @param string $apiKey
     * @param string $secret
     */
    public function __construct(string $apiKey, string $secret)
    {
        $this->apiKey = $apiKey;
        $this->secret = $secret;
    }

    /**
     * Get API key
     *
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->apiKey;
    }

    /**
     * Get API secret
     *
     * @return string
     */
    public function getSecret(): string
    {
        return $this->secret;
    }
}