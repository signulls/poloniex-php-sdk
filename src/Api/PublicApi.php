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

namespace Poloniex\Api;

use GuzzleHttp\RequestOptions;
use Poloniex\Response\PublicApi\{
    ChartData,
    Currency,
    DayVolume,
    LoanOrders,
    OrderBook,
    Ticker,
    TradeHistory
};

/**
 * Class PublicApi
 *
 * There are six public methods, all of which take HTTP GET requests and return output in JSON format.
 */
class PublicApi extends AbstractApi
{
    /**
     * {@inheritdoc}
     */
    public function request(string $command, array $params = []): array
    {
        $this->options = [RequestOptions::QUERY => array_merge($params, ['command' => $command])];

        return parent::request($command, $params);
    }

    /**
     * Returns the ticker for all markets
     * Keys of array are pairs like 'ETH_CVC'
     *
     * @return Ticker[]
     */
    public function ticker(): array
    {
        $tickers = [];
        foreach ($this->request('returnTicker') as $pair => $response) {
            /* @var $ticker Ticker */
            $ticker = $this->factory(Ticker::class, $response);
            $ticker->pair = $pair;

            $tickers[$pair] = $ticker;
        }

        return $tickers;
    }

    /**
     * Returns the 24-hour volume for all markets, plus totals for primary currencies.
     *
     * @return DayVolume
     */
    public function dayVolume(): DayVolume
    {
        $response = new DayVolume();

        foreach ($this->request('return24hVolume') as $pair => $contents) {
            if (strpos($pair, 'total') !== false) {
                $response->total[str_replace('total', '', $pair)] = $contents;

                continue;
            }

            $response->volume[$pair] = $contents;
        }

        return $response;
    }

    /**
     * Returns the order book for a given market, as well as a sequence number for use
     * with the Push API and an indicator specifying whether the market is frozen.
     * You may set currencyPair to "all" to get the order books of all markets.
     *
     * @param string|null $currencyPair example: BTC_NXT
     * @param int|null $depth example: 10
     *
     * @return OrderBook
     */
    public function orderBook(string $currencyPair, int $depth = null): OrderBook
    {
        /* @var $orderBook OrderBook */
        $orderBook = $this->factory(OrderBook::class, $this->request('returnOrderBook', [
            'currencyPair' => strtoupper($currencyPair),
            'depth'        => $depth
        ]));

        return $orderBook;
    }

    /**
     * Returns the past 200 trades for a given market, or up to 50,000 trades between a range
     * specified in UNIX timestamps by the "start" and "end" GET parameters.
     *
     * @param string $currencyPair BTC_NXT
     * @param int $start 1410158341
     * @param int $end 1410499372
     *
     * @return TradeHistory[]
     */
    public function tradeHistory(string $currencyPair, int $start = null, int $end = null): array
    {
        $tradeHistories = [];
        foreach ($this->request('returnTradeHistory', [
            'currencyPair' => strtoupper($currencyPair),
            'start'        => $start ?: time(),
            'end'          => $end,
        ]) as $response) {
            $tradeHistories[] = $this->factory(TradeHistory::class, $response);
        }

        return $tradeHistories;
    }

    /**
     * Returns candlestick chart data.
     *
     * Required GET parameters are: "currencyPair", "period" (candlestick period in seconds; valid
     * values are 300, 900, 1800, 7200, 14400, and 86400), "start", and "end". "Start" and "end" are
     * given in UNIX timestamp format and used to specify the date range for the data returned.
     *
     * @param string $currencyPair example: BTC_XMR
     * @param int $start example: 1405699200
     * @param int $end example: 9999999999
     * @param int $period example: 300
     *
     * @return ChartData[]
     */
    public function chartData(string $currencyPair, int $start = null, int $end = null, int $period = 300): array
    {
        $this->throwExceptionIf(
            !\in_array($period, [300, 900, 1800, 7200, 14400, 86400], true),
            sprintf('Invalid period %d given.', $period)
        );

        $chartData = [];
        foreach ($this->request('returnChartData', [
            'currencyPair' => strtoupper($currencyPair),
            'start'        => $start ?: time() - 60 * 60,
            'end'          => $end ?: time(),
            'period'       => $period,
        ]) as $response) {
            $chartData[] = $this->factory(ChartData::class, $response);
        }

        return $chartData;
    }

    /**
     * Returns information about currencies.
     * NOTE: keys of array are 3-digit name of currency
     *
     * @return Currency[]
     */
    public function currencies(): array
    {
        $currencies = [];
        foreach ($this->request('returnCurrencies') as $key => $response) {
            /* @var $currency Currency */
            $currencies[$key] = $this->factory(Currency::class, $response);
        }

        return $currencies;
    }

    /**
     * Returns the list of loan offers and demands for a given currency, specified by the "currency" GET parameter.
     *
     * @param string $currency 3-digit currency
     * @return LoanOrders
     */
    public function loanOrders(string $currency): LoanOrders
    {
        /* @var $loanOrders LoanOrders */
        $loanOrders = $this->factory(
            LoanOrders::class,
            $this->request('returnLoanOrders', compact('currency'))
        );

        return $loanOrders;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequestMethod(): string
    {
        return 'GET';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequestUri(): string
    {
        return 'public';
    }
}