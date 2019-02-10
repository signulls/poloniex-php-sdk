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

use Predis\Client;
use DateTime;

/**
 * Class RedisCallHistory
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class RedisCallHistory implements CallHistoryInterface
{
    /**
     * Client class used for connecting and executing commands on Redis.
     *
     * @var Client
     */
    protected $redisClient;

    /**
     * Time for cache
     *
     * @var string
     */
    protected $expireTime;

    /**
     * @var string
     */
    private $ip;

    /**
     * @var string
     */
    private $key;

    /**
     * RedisCallHistory constructor.
     *
     * @param Client $client
     * @param string $expireTime
     * @param string $key
     */
    public function __construct(Client $client, string $expireTime = '1 hour', string $key = 'poloniex:calls')
    {
        $this->ip = gethostbyname(gethostname());
        $this->expireTime = $expireTime;
        $this->redisClient = $client;
        $this->key = $key;
    }

    /**
     * {@inheritdoc}
     */
    public function create(string $proxy = null): void
    {
        $key = $this->getKey($proxy);

        $this->redisClient->hincrby($key, $this->getTime(), 1);
        $this->redisClient->expireat($key, strtotime('+' . $this->expireTime));
    }

    /**
     * {@inheritdoc}
     */
    public function isIncreased(string $proxy = null): bool
    {
        return $this->redisClient->hget($this->getKey($proxy), $this->getTime()) >= self::CALLS_PER_SECOND;
    }

    /**
     * Create time key based by one second
     *
     * @return string
     */
    private function getTime(): string
    {
        return (new DateTime())->format('Y:m:d:H:i:s');
    }

    /**
     * Get redis key
     *
     * @param string|null $proxy
     * @return string
     */
    private function getKey(string $proxy = null): string
    {
        return $this->key . ':' . ($proxy ?: $this->ip);
    }
}