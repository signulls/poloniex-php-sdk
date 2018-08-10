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

use GuzzleHttp\{Client, RequestOptions};
use Poloniex\CallHistory\CallHistoryInterface;
use Psr\Http\Message\ResponseInterface;

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
    /**
     * @var CallHistoryInterface
     */
    private $callHistory;

    /**
     * Timeout in seconds
     *
     * @var int
     */
    private $timeout;

    /**
     * PoloniexClient constructor.
     *
     * @param CallHistoryInterface $callHistory
     * @param string $baseUri
     * @param int $timeout
     * @param string|null $proxy
     */
    public function __construct(
        CallHistoryInterface $callHistory,
        string $baseUri = 'https://poloniex.com/',
        int $timeout = 0,
        string $proxy = null
    ) {
        $this->callHistory = $callHistory;
        $this->timeout = $timeout;

        parent::__construct([
            'base_uri' => $baseUri,
            RequestOptions::ALLOW_REDIRECTS => false,
            RequestOptions::PROXY => $proxy,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        $wait = false;

        do {
            if ($wait) {
                sleep(1);
            }
            $wait = true;
        } while ($this->callHistory->isIncreased());

        $response = parent::request($method, $uri, array_merge(['timeout' => $this->timeout], $options));
        $this->callHistory->create();

        return $response;
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