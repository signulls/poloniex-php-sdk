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
     * @param LoggerInterface      $logger
     * @param CallHistoryInterface $callHistory
     * @param int                  $timeout
     * @param string               $baseUri
     */
    public function __construct(
        LoggerInterface $logger,
        CallHistoryInterface $callHistory,
        int $timeout = 5,
        string $baseUri = self::BASE_URI
    ) {
        $this->setLogger($logger);
        $this->callHistory = $callHistory;

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
        if ($this->callHistory->isIncreased()) {
            $this->logger->warning('Limit increased. Sleep for 1 second.');
            sleep(1);
        }

        $this->callHistory->create();
        $method = strtoupper($method);
        $this->logger->debug(sprintf('Send %s request to %s', $method, $this->getConfig('base_uri') . $uri), $options);

        return parent::request(strtoupper($method), $uri, $options);
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
}