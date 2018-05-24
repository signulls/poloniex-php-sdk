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

namespace Poloniex\Tests\Api;

use Poloniex\Api\PublicApi;
use Poloniex\Response\PublicApi\{
    ChartData,
    Ticker,
    Currency,
    LoanOrders,
    OrderBook,
    TradeHistory
};

/**
 * Class PublicApiTest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class PublicApiTest extends AbstractPoloniexTest
{
    private const PATH_RESPONSES = 'tests/response/public/%s.json';

    /**
     * @var PublicApi
     */
    private $publicApi;

    /**
     * Test ticker
     */
    public function testTicker(): void
    {
        $this->prepareApi('returnTicker');
        $this->checkCollectionResponse('returnTicker', $this->publicApi->returnTicker(), Ticker::class);
    }

    /**
     * @dataProvider tradeHistoryProvider
     *
     * @param string $currencyPair
     */
    public function testTradeHistory(string $currencyPair): void
    {
        $this->prepareApi('returnTradeHistory');
        $this->checkCollectionResponse(
            'returnTradeHistory',
            $this->publicApi->returnTradeHistory($currencyPair),
            TradeHistory::class
        );
    }

    /**
     * Test order book
     */
    public function testOrderBook(): void
    {
        $this->prepareApi('returnOrderBook');
        $this->checkResponse('returnOrderBook', $this->publicApi->returnOrderBook('BTC_NXT'), OrderBook::class);
    }

    /**
     * Test all order book
     */
    public function testAllOrderBook(): void
    {
        $this->prepareApi('returnOrderBookAll');
        $this->checkCollectionResponse('returnOrderBookAll', $this->publicApi->returnAllOrderBook(), OrderBook::class);
    }

    /**
     * Test currencies
     */
    public function testsCurrencies(): void
    {
        $this->prepareApi('returnCurrencies');
        $this->checkCollectionResponse('returnCurrencies', $this->publicApi->returnCurrencies(), Currency::class);
    }

    /**
     * @dataProvider chartDataProvider
     *
     * @param $currencyPair
     * @param $start
     * @param $end
     * @param $period
     */
    public function testsChartData($currencyPair, $start, $end, $period): void
    {
        $this->prepareApi('returnChartData');
        $this->checkCollectionResponse(
            'returnChartData',
            $this->publicApi->returnChartData($currencyPair, $start, $end, $period),
            ChartData::class
        );
    }

    /**
     * @dataProvider loanOrdersProvider
     *
     * @param string $currency
     */
    public function testLoanOrders(string $currency): void
    {
        $this->prepareApi('returnLoanOrders');
        $this->checkResponse('returnLoanOrders', $this->publicApi->returnLoanOrders($currency), LoanOrders::class);
    }

    /**
     * Test 24h volume
     */
    public function testDayVolume(): void
    {
        $json = $this->getJsonResponse('return24hVolume');
        $this->prepareApi('return24hVolume');
        $dayVolume = $this->publicApi->return24hVolume();

        foreach ($json as $key => $value) {
            if (strpos($key, 'total') !== false) {
                $this->assertEquals($value, $dayVolume->total[str_replace('total', '', $key)]);

                continue;
            }

            $this->assertEquals($value, $dayVolume->volume[$key]);
        }
    }

    /**
     * Chart data provider
     *
     * @return array
     */
    public function chartDataProvider(): array
    {
        return [
            ['BTC_XMR', 1311033100, 1311233100, 900],
            ['BTC_ETH', 1311033100, 1311233100, 900],
        ];
    }

    public function loanOrdersProvider(): array
    {
        return [
            ['BTC'],
        ];
    }

    public function tradeHistoryProvider(): array
    {
        return [
            ['BTC_NXT'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareApi(string $command): void
    {
        $this->mockPoloniexClient($command);
        $this->publicApi = new PublicApi($this->poloniexClient, $this->getSerializer());
    }

    /**
     * {@inheritdoc}
     */
    protected function getJsonPath(): string
    {
        return self::PATH_RESPONSES;
    }
}
