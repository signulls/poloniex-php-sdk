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

/**
 * Class PoloniexManager
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
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
     * @param ApiKey $apiKey   User credentials
     * @param string $currency Any available currency at market (DOGE, LTC, ETH, USDT, XMR etc..)
     *
     * @return float
     * @throws PoloniexException
     */
    public function getBalance(ApiKey $apiKey, string $currency = 'BTC'): float
    {
        $currency = strtoupper($currency);
        $completeBalances = $this->tradingApi->setApiKey($apiKey)->returnCompleteBalances();
        $balance = 0;

        foreach ($completeBalances as $coin => $completeBalance) {
            $balance += $completeBalance->btcValue;
        }

        if ($currency !== 'BTC') {
            $ticker = $this->publicApi->returnTicker();
            $btcCoin = 'BTC_' . $currency;
            $coinBtc = $currency . '_BTC';

            if (isset($ticker[$coinBtc])) {
                $balance *= $ticker[$coinBtc]->last;
            } elseif (isset($ticker[$btcCoin])) {
                $balance /= $ticker[$btcCoin]->last;
            } else {
                throw new PoloniexException(sprintf('Invalid currency given: %s', $currency));
            }
        }

        return $balance;
    }

    /**
     * Get available balance for given coin.
     * You can use available balance for trades.
     *
     * @param ApiKey $apiKey
     * @param string $coin
     *
     * @return float|null
     */
    public function getAvailableBalance(ApiKey $apiKey, string $coin):? float
    {
        $balances = $this->tradingApi->setApiKey($apiKey)->returnCompleteBalances();

        if (!isset($balances[$coin])) {
            throw new PoloniexException(sprintf('Invalid coin given: %s', $coin));
        }

        return $balances[$coin]->available;
    }

    /**
     * Get asks for given trade pair
     *
     * @param string $pair
     *
     * @return float[] Keys are prices and values are amount of trades
     */
    public function asks(string $pair): array
    {
        $asks = [];
        foreach ($this->publicApi->returnOrderBook($pair)->asks as $ask) {
            $asks[$ask[0]] = $ask[1];
        }

        ksort($asks);

        return $asks;
    }

    /**
     * Get bids
     *
     * @param string $pair
     *
     * @return float[] Keys are prices and values are amount of trades
     */
    public function bids(string $pair): array
    {
        $bids = [];
        foreach ($this->publicApi->returnOrderBook($pair)->bids as $bid) {
            $bids[$bid[0]] = $bid[1];
        }

        ksort($bids);

        return $bids;
    }
}