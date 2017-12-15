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

namespace Poloniex;

use GuzzleHttp\Client;
use Poloniex\CallHistory\CallHistoryInterface;
use Psr\Log\{LoggerAwareTrait, LoggerInterface};

/**
 * Class PoloniexClient
 *
 * NOTE: Currency pairs are reverse of what most exchanges use.
 *       For instance, instead of XPM_BTC, use BTC_XPM
 *
 * @link   https://poloniex.com/support/api/
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class PoloniexClient extends Client
{
    use LoggerAwareTrait;

    /**
     * Base url for poloniex api requests
     */
    public const BASE_URI = 'https://poloniex.com/';

    /**
     * @var CallHistoryInterface
     */
    private $callHistory;

    /**
     * PoloniexClient constructor.
     *
     * @param CallHistoryInterface $callHistory
     * @param LoggerInterface      $logger
     * @param int                  $timeout
     * @param string               $baseUri
     */
    public function __construct(
        CallHistoryInterface $callHistory = null,
        LoggerInterface $logger = null,
        int $timeout = 5,
        string $baseUri = self::BASE_URI
    ) {
        $this->callHistory = $callHistory;
        if ($logger !== null) {
            $this->setLogger($logger);
        }

        parent::__construct([
            'base_uri'        => $baseUri,
            'timeout'         => $timeout,
            'allow_redirects' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri = '', array $options = [])
    {
        if ($this->callHistory !== null) {
            if ($this->callHistory->isIncreased()) {
                $this->log('warning', 'Limit increased. Sleep for 1 second.');
                sleep(1);
            }

            $this->callHistory->create();
        }

        $this->log('debug', sprintf('Send %s request to %s', $method, $this->getConfig('base_uri') . $uri), $options);

        return parent::request($method, $uri, $options);
    }

    /**
     * Check whether service is accessible
     *
     * @return bool
     */
    public function isInaccessible(): bool
    {
        return $this->get('/')->getStatusCode() !== 200;
    }

    /**
     * Log message
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     */
    public function log(string $level, string $message, array $context = []): void
    {
        if ($this->logger !== null) {
            $this->logger->log($level, $message, $context);
        }
    }
}