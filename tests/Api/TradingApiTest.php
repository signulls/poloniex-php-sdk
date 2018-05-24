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

use Mockery;
use Poloniex\Api\TradingApi;
use Poloniex\ApiKey;
use Poloniex\Exception\PoloniexException;
use Poloniex\NonceProvider\FilesystemNonceProvider;
use Poloniex\Request\{CreateLoanOfferRequest, MoveOrderRequest, TradeRequest};
use Poloniex\Response\SampleResponse;
use Poloniex\Response\TradingApi\{
    ActiveLoans,
    AvailableAccountBalances,
    CreateLoanOffer,
    FeeInfo,
    LandingHistory,
    Loan,
    MarginAccountSummary,
    MarginPosition,
    MoveOrder,
    CompleteBalance,
    DepositsWithdrawals,
    NewAddress,
    OpenOrder,
    OrderTrade,
    ResultingTrade,
    TradeHistory
};

/**
 * Class TradingApiTest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradingApiTest extends AbstractPoloniexTest
{
    public const PATH_RESPONSES = 'tests/response/trading/%s.json';

    /**
     * @var TradingApi
     */
    private $tradingApi;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        parent::setUp();

        $nonceProvider = Mockery::mock(new FilesystemNonceProvider('tests/data'));
        $nonceProvider->shouldReceive('get')->andReturn(1);
        $nonceProvider ->shouldReceive('increase')->andReturns();

        $this->tradingApi = new TradingApi(
            $this->poloniexClient,
            $this->getSerializer(),
            $nonceProvider
        );

        $this->tradingApi->setApiKey(new ApiKey('api-key', 'api-secret'));
    }

    /**
     * @dataProvider buyProvider
     *
     * @param string $currencyPair
     * @param string $rate
     * @param string $amount
     * @param string $exception
     */
    public function testBuy(
        string $currencyPair,
        string $rate,
        string $amount,
        string $exception = null
    ): void {
        $this->prepareApi('buy');
        $json = $this->getJsonResponse('buy');

        if ($exception !== null) {
            $this->expectException($exception);
        }

        $tradeRequest = new TradeRequest();
        $tradeRequest->currencyPair = $currencyPair;
        $tradeRequest->rate = $rate;
        $tradeRequest->amount = $amount;

        $buy = $this->tradingApi->buy($tradeRequest);

        $this->assertSame($json['orderNumber'], $buy->orderNumber);

        $resultingTrades = $json['resultingTrades'] ?? [];

        foreach ($resultingTrades as $key => $resultingTrade) {
            $this->assertInstanceOf(ResultingTrade::class, $buy->resultingTrades[$key]);
            $this->checkDataResponse($resultingTrade, $buy->resultingTrades[$key]);
        }
    }

    /**
     * Test sell
     */
    public function testSell(): void
    {
        $this->prepareApi('sell');
        $json = $this->getJsonResponse('sell');

        $tradeRequest = new TradeRequest();
        $tradeRequest->currencyPair = 'VTC_RTG';
        $tradeRequest->rate = 1.2;
        $tradeRequest->amount = 3.4;

        $sell = $this->tradingApi->sell($tradeRequest);

        $this->assertSame($json['orderNumber'], $sell->orderNumber);

        $resultingTrades = $json['resultingTrades'] ?? [];

        foreach ($resultingTrades as $key => $resultingTrade) {
            $this->assertInstanceOf(ResultingTrade::class, $sell->resultingTrades[$key]);
            $this->checkDataResponse($resultingTrade, $sell->resultingTrades[$key]);
        }
    }

    /**
     * @return array
     */
    public function buyProvider(): array
    {
        return [
            ['BTC_ETH', 1.00041, 100],
            ['BTC_BTC', 1.00041, 100, PoloniexException::class],
        ];
    }

    /**
     * Test return balances
     */
    public function testReturnBalances(): void
    {
        $json = $this->getJsonResponse('returnBalances');
        $this->prepareApi('returnBalances');
        $balance = $this->tradingApi->returnBalances();

        foreach ($json as $currency => $expected) {
            $this->assertEquals($expected, $balance->currencies[$currency]);
        }
    }

    /**
     *  Test returnCompleteBalances
     */
    public function testReturnCompleteBalances(): void
    {
        $this->prepareApi('returnCompleteBalances');
        $this->checkCollectionResponse(
            'returnCompleteBalances',
            $this->tradingApi->returnCompleteBalances(),
            CompleteBalance::class
        );
    }

    /**
     * Test returnDepositAddresses
     */
    public function testReturnDepositAddresses(): void
    {
        $json = $this->getJsonResponse('returnDepositAddresses');
        $this->prepareApi('returnDepositAddresses');
        $depositAddresses = $this->tradingApi->returnDepositAddresses();

        foreach ($json as $currency => $expected) {
            $this->assertEquals($expected, $depositAddresses->addresses[$currency]);
        }
    }

    /**
     * Test generate new address
     */
    public function testGenerateNewAddress(): void
    {
        $this->prepareApi('generateNewAddress');
        $this->checkResponse('generateNewAddress', $this->tradingApi->generateNewAddress('BTC'), NewAddress::class);
    }

    /**
     *  Test return deposits withdrawals
     */
    public function testReturnDepositsWithdrawals(): void
    {
        $this->prepareApi('returnDepositsWithdrawals');
        $this->checkResponse(
            'returnDepositsWithdrawals',
            $this->tradingApi->returnDepositsWithdrawals(123, 456),
            DepositsWithdrawals::class
        );
    }


    /**
     * Test return open orders
     */
    public function testReturnOpenOrders(): void
    {
        $this->prepareApi('returnOpenOrders');
        $this->checkCollectionResponse(
            'returnOpenOrders',
            $this->tradingApi->returnOpenOrders('BTC_TCS'),
            OpenOrder::class
        );
    }

    /**
     * Test return open orders
     */
    public function testReturnAllOpenOrders(): void
    {
        $this->prepareApi('returnAllOpenOrders');
        $json = $this->getJsonResponse('returnAllOpenOrders');
        $allOpenOrders = $this->tradingApi->returnAllOpenOrders();

        /* @var $openOrders array */
        foreach ($json as $currency => $openOrders) {
            $this->assertNotEmpty($allOpenOrders[$currency]);

            /* @var $openOrder array */
            foreach ($openOrders as $key => $openOrder) {
                $this->assertInstanceOf(OpenOrder::class, $allOpenOrders[$currency][$key]);
                $this->checkDataResponse($openOrder, $allOpenOrders[$currency][$key]);
            }
        }
    }

    /**
     * Test return trade history
     */
    public function testReturnTradeHistory(): void
    {
        $this->prepareApi('returnTradeHistory');
        $this->checkCollectionResponse(
            'returnTradeHistory',
            $this->tradingApi->returnTradeHistory('BTC_ETH'),
            TradeHistory::class
        );
    }

    /**
     * Test return all trade history
     */
    public function testReturnAllTradeHistory(): void
    {
        $this->prepareApi('returnAllTradeHistory');
        $json = $this->getJsonResponse('returnAllTradeHistory');
        $allTradeHistory = $this->tradingApi->returnAllTradeHistory();

        /* @var $tradeHistories array */
        foreach ($json as $currency => $tradeHistories) {
            $this->assertNotEmpty($allTradeHistory[$currency]);

            /* @var $tradeHistory array */
            foreach ($tradeHistories as $key => $tradeHistory) {
                $this->assertInstanceOf(TradeHistory::class, $allTradeHistory[$currency][$key]);
                $this->checkDataResponse($tradeHistory, $allTradeHistory[$currency][$key]);
            }
        }
    }

    /**
     * Test return order trades
     */
    public function testReturnOrderTrades(): void
    {
        $this->prepareApi('returnOrderTrades');

        $this->checkCollectionResponse(
            'returnOrderTrades',
            $this->tradingApi->returnOrderTrades(123),
            OrderTrade::class
        );
    }

    /**
     * Test cancel order
     */
    public function testCancelOrder(): void
    {
        $this->prepareApi('cancelOrder');
        $success = $this->tradingApi->cancelOrder(123);
        $json = $this->getJsonResponse('cancelOrder');
        $this->assertSame((bool) $json['success'], $success);
    }

    /**
     * Test move order
     */
    public function testMoveOrder(): void
    {
        $this->prepareApi('moveOrder');

        $moveOrderRequest = new MoveOrderRequest();
        $moveOrderRequest->orderNumber = 1;
        $moveOrderRequest->rate = 2;
        $moveOrderRequest->amount = 3;

        $this->checkResponse('moveOrder', $this->tradingApi->moveOrder($moveOrderRequest), MoveOrder::class);
    }

    /**
     * Test withdraw
     */
    public function testWithdraw(): void
    {
        $this->prepareApi('withdraw');
        $json = $this->getJsonResponse('withdraw');
        $response = $this->tradingApi->withdraw('BTC', 2, 'test-address');

        $this->assertSame($json['response'], $response);
    }

    /**
     * Test return fee info
     */
    public function testReturnFeeInfo(): void
    {
        $this->prepareApi('returnFeeInfo');
        $this->checkResponse('returnFeeInfo', $this->tradingApi->returnFeeInfo(), FeeInfo::class);
    }

    /**
     * Test return available account balances
     */
    public function testReturnAvailableAccountBalances(): void
    {
        $this->prepareApi('returnAvailableAccountBalances');
        $this->checkResponse(
            'returnAvailableAccountBalances',
            $this->tradingApi->returnAvailableAccountBalances(),
            AvailableAccountBalances::class
        );
    }

    /**
     * Test return tradable balances
     */
    public function testReturnTradableBalances(): void
    {
        $this->prepareApi('returnTradableBalances');
        $this->assertSame(
            $this->getJsonResponse('returnTradableBalances'),
            $this->tradingApi->returnTradableBalances()
        );
    }

    /**
     * Test transfer balance
     */
    public function testTransferBalance(): void
    {
        $this->prepareApi('transferBalance');
        $this->checkResponse(
            'transferBalance',
            $this->tradingApi->transferBalance('BTC', 1, 'from', 'to'),
            SampleResponse::class
        );
    }

    /**
     * Test return margin account summary
     */
    public function testReturnMarginAccountSummary(): void
    {
        $this->prepareApi('returnMarginAccountSummary');
        $this->checkResponse(
            'returnMarginAccountSummary',
            $this->tradingApi->returnMarginAccountSummary(),
            MarginAccountSummary::class
        );
    }

    /**
     * Test margin buy
     */
    public function testMarginBuy(): void
    {
        $this->prepareApi('marginBuy');
        $json = $this->getJsonResponse('marginBuy');
        $marginTrade = $this->tradingApi->marginBuy('BTC_ETH', 14.88, 4);

        $this->assertSame($json['success'], $marginTrade->success);
        $this->assertSame($json['message'], $marginTrade->message);
        $this->assertSame((int) $json['orderNumber'], $marginTrade->orderNumber);

        $resultingTrades = $json['resultingTrades'] ?? [];

        /* @var $trades array */
        foreach ($resultingTrades as $currencyPair => $trades) {
            foreach ($trades as $key => $trade) {
                $this->assertInstanceOf(ResultingTrade::class, $marginTrade->resultingTrades[$currencyPair][$key]);
                $this->checkDataResponse($trade, $marginTrade->resultingTrades[$currencyPair][$key]);
            }
        }
    }

    /**
     * Test margin buy
     */
    public function testMarginSell(): void
    {
        $this->prepareApi('marginSell');
        $json = $this->getJsonResponse('marginSell');
        $marginTrade = $this->tradingApi->marginSell('BTC_ETH', 14.88, 4);

        $this->assertSame($json['success'], $marginTrade->success);
        $this->assertSame($json['message'], $marginTrade->message);
        $this->assertSame((int) $json['orderNumber'], $marginTrade->orderNumber);

        $resultingTrades = $json['resultingTrades'] ?? [];

        /* @var $trades array */
        foreach ($resultingTrades as $currencyPair => $trades) {
            foreach ($trades as $key => $trade) {
                $this->assertInstanceOf(ResultingTrade::class, $marginTrade->resultingTrades[$currencyPair][$key]);
                $this->checkDataResponse($trade, $marginTrade->resultingTrades[$currencyPair][$key]);
            }
        }
    }

    /**
     * Test get margin position
     */
    public function testGetMarginPosition(): void
    {
        $this->prepareApi('getMarginPosition');
        $this->checkResponse(
            'getMarginPosition',
            $this->tradingApi->getMarginPosition('BTC_ETH'),
            MarginPosition::class
        );
    }

    /**
     * Test close margin position
     */
    public function testCloseMarginPosition(): void
    {
        $this->prepareApi('closeMarginPosition');
        $json = $this->getJsonResponse('closeMarginPosition');
        $closeMarginPosition = $this->tradingApi->closeMarginPosition('BTC_ETH');

        $this->assertSame((bool) $json['success'], $closeMarginPosition->success);
        $this->assertSame($json['message'], $closeMarginPosition->message);
        $resultingTrades = $json['resultingTrades'] ?? [];

        /* @var $trades array */
        foreach ($resultingTrades as $currencyPair => $trades) {
            foreach ($trades as $key => $trade) {
                $this->assertInstanceOf(
                    ResultingTrade::class,
                    $closeMarginPosition->resultingTrades[$currencyPair][$key]
                );

                $this->checkDataResponse($trade, $closeMarginPosition->resultingTrades[$currencyPair][$key]);
            }
        }
    }

    /**
     * Test create loan order
     */
    public function testCreateLoanOffer(): void
    {
        $this->prepareApi('createLoanOffer');

        $request = new CreateLoanOfferRequest();
        $request->amount = 10;
        $request->currency = 'BTC_ETH';
        $request->duration = 23;
        $request->autoRenew = 1;
        $request->lendingRate = 1.3;

        $this->checkResponse(
            'createLoanOffer',
            $this->tradingApi->createLoanOffer($request),
            CreateLoanOffer::class
        );
    }

    /**
     * Test cancel loan offer
     */
    public function testCancelLoanOffer(): void
    {
        $this->prepareApi('cancelLoanOffer');
        $this->checkResponse(
            'cancelLoanOffer',
            $this->tradingApi->cancelLoanOffer(123),
            SampleResponse::class
        );
    }

    /**
     * Test return open loan offers
     */
    public function testReturnOpenLoanOffers(): void
    {
        $this->prepareApi('returnOpenLoanOffers');
        $json = $this->getJsonResponse('returnOpenLoanOffers');
        $loans = $this->tradingApi->returnOpenLoanOffers();

        /* @var $offers array */
        foreach ($json as $currency => $offers) {
            foreach ($offers as $key => $offer) {
                $this->assertInstanceOf(Loan::class, $loans[$currency][$key]);
                $this->checkDataResponse($offer, $loans[$currency][$key]);
            }
        }
    }

    /**
     * Test return active loans
     */
    public function testReturnActiveLoans(): void
    {
        $this->prepareApi('returnActiveLoans');
        $this->checkResponse(
            'returnActiveLoans',
            $this->tradingApi->returnActiveLoans(),
            ActiveLoans::class
        );
    }

    /**
     * Test return lending history
     */
    public function testReturnLendingHistory(): void
    {
        $this->prepareApi('returnLendingHistory');
        $this->checkCollectionResponse(
            'returnLendingHistory',
            $this->tradingApi->returnLendingHistory(1, 2, 4),
            LandingHistory::class
        );
    }

    /**
     * Test toggle auto renew
     */
    public function testToggleAutoRenew(): void
    {
        $this->prepareApi('toggleAutoRenew');
        $this->checkResponse(
            'toggleAutoRenew',
            $this->tradingApi->toggleAutoRenew(1),
            SampleResponse::class
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function prepareApi(string $command): void
    {
        $this->mockPoloniexClient($command);

        $nonceProvider = Mockery::mock(new FilesystemNonceProvider('tests/data'));
        $nonceProvider->shouldReceive('get')->andReturn(1);
        $nonceProvider->shouldReceive('increase')->andReturns();

        $this->tradingApi = new TradingApi(
            $this->poloniexClient,
            $this->getSerializer(),
            $nonceProvider
        );

        $this->tradingApi->setApiKey(new ApiKey('api-key', 'api-secret'));
    }

    /**
     * {@inheritdoc}
     */
    protected function getJsonPath(): string
    {
        return self::PATH_RESPONSES;
    }
}
