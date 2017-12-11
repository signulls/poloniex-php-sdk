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
use Predis\Client;

/**
 * Class RedisNonceProvider
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class RedisNonceProvider implements NonceProviderInterface, IncreasingNonceInterface
{
    private const MAIN_KEY = 'poloniex:nonce';

    /**
     * Client class used for connecting and executing commands on Redis.
     *
     * @var Client
     */
    protected $redisClient;

    /**
     * RedisNonceProvider constructor.
     *
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->redisClient = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function get(ApiKey $apiKey): int
    {
        return (int) $this->redisClient->hget(self::MAIN_KEY, $this->getField($apiKey));
    }

    /**
     * {@inheritdoc}
     */
    public function increase(ApiKey $apiKey): void
    {
        $this->redisClient->hincrby(self::MAIN_KEY, $this->getField($apiKey), 1);
    }

    /**
     * Generate specific filename for given ApiKey
     *
     * @param ApiKey $apiKey
     * @return string
     */
    protected function getField(ApiKey $apiKey): string
    {
        return md5($apiKey->getApiKey());
    }
}