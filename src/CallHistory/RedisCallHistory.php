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
    private const MAIN_KEY = 'poloniex:calls';

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
     * RedisCallHistory constructor.
     *
     * @param Client $client
     * @param string $expireTime
     */
    public function __construct(Client $client, string $expireTime = '1 hour')
    {
        $this->expireTime = $expireTime;
        $this->redisClient = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function create(): void
    {
        $this->redisClient->hincrby(self::MAIN_KEY, $this->getTime(), 1);
        $this->redisClient->expireat(self::MAIN_KEY, strtotime('+' . $this->expireTime));
    }

    /**
     * {@inheritdoc}
     */
    public function isIncreased(): bool
    {
        return $this->redisClient->hget(self::MAIN_KEY, $this->getTime()) >= self::CALLS_PER_SECOND;
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
}