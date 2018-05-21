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
     * Base url for poloniex api requests
     */
    public const BASE_URI = 'https://poloniex.com/';

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
     * @param string               $baseUri
     * @param int                  $timeout
     */
    public function __construct(
        CallHistoryInterface $callHistory = null,
        string $baseUri = self::BASE_URI,
        int $timeout = 0
    ) {
        $this->callHistory = $callHistory;
        $this->timeout = $timeout;

        parent::__construct([
            'base_uri' => $baseUri,
            'allow_redirects' => false,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function request($method, $uri = '', array $options = []): ResponseInterface
    {
        if ($this->callHistory !== null) {
            if ($this->callHistory->isIncreased()) {
                sleep(1);
            }

            $this->callHistory->create();
        }

        return parent::request($method, $uri, array_merge(['timeout' => $this->timeout], $options));
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