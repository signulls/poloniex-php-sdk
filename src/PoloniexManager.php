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

use Poloniex\Api\{PublicApi, TradingApi};
use Poloniex\Exception\PoloniexException;

final class PoloniexManager
{
    /**
     * @var PublicApi
     */
    private $publicApi;

    /**
     * @var TradingApi
     */
    private $tradingApi;

    /**
     * PoloniexManager constructor.
     *
     * @param PublicApi  $publicApi
     * @param TradingApi $tradingApi
     */
    public function __construct(PublicApi $publicApi, TradingApi $tradingApi)
    {
        $this->publicApi = $publicApi;
        $this->tradingApi = $tradingApi;
    }

    /**
     * Get total balance for given currency
     *
     * @param ApiKey $apiKey
     * @param string $currency
     *
     * @return float
     */
    public function getBalance(ApiKey $apiKey, string $currency = 'BTC'): float
    {
        $currency = strtoupper($currency);
        $this->tradingApi->setApiKey($apiKey);
        $completeBalances = $this->tradingApi->returnCompleteBalances();
        $ticker = $currency !== 'BTC' ? $this->publicApi->returnTicker() : null;

        $balance = 0;

        foreach ($completeBalances as $coin => $completeBalance) {
            if ($currency === 'BTC') {
                $balance += $completeBalance->btcValue;

                continue;
            }

            $pair = $currency . '_' . strtoupper($coin);

            if (!isset($ticker[$pair])) {
                throw new PoloniexException(sprintf('Invalid currency given: %s', $currency));
            }

            if ($completeBalance->available > 0) {
                $balance += $completeBalance->available * $ticker[$pair]->last;
            }

            if ($completeBalance->onOrders > 0) {
                $balance += $completeBalance->onOrders * $ticker[$pair]->last;
            }
        }

        return $balance;
    }
}