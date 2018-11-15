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

namespace Poloniex\Api;

use function is_array;
use GuzzleHttp\RequestOptions;
use Poloniex\{ApiKey, Exception\TotalDeficiencyException, Response\SampleResponse};
use Poloniex\Request\{CreateLoanOfferRequest, MoveOrderRequest, TradeRequest};
use Poloniex\Response\TradingApi\{
    AvailableAccountBalances,
    Balance,
    MoveOrder,
    OrderStatus,
    TradeResult,
    CompleteBalance,
    DepositAddresses,
    DepositsWithdrawals,
    FeeInfo,
    ActiveLoans,
    CreateLoanOffer,
    LandingHistory,
    Loan,
    CloseMarginPosition,
    MarginPosition,
    MarginAccountSummary,
    MarginTrade,
    NewAddress,
    OpenOrder,
    OrderTrade,
    ResultingTrade,
    TradeHistory
};

/**
 * All calls to the trading API are sent via HTTP POST to https://poloniex.com/tradingApi and
 * must contain the following headers:
 *
 *  Key - Your API key.
 *  Sign - The query's POST data signed by your key's "secret" according to the HMAC-SHA512 method.
 *
 * Additionally, all queries must include a "nonce" POST parameter. The nonce parameter is an integer
 * which must always be greater than the previous nonce used.
 *
 * There are several methods accepted by the trading API, each of which is specified by the "command" POST parameter.
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class TradingApi extends AbstractApi
{
    /**
     * @var ApiKey
     */
    private $apiKey;

    /**
     * {@inheritdoc}
     */
    public function request(string $command, array $params = []): array
    {
        $this->throwExceptionIf($this->apiKey === null, 'You need to set ApiKey to make trade request');
        $params = array_merge($params, ['nonce' => $this->getNonce(), 'command' => $command]);
        $data = http_build_query($params, '', '&');

        $this->options = [
            RequestOptions::FORM_PARAMS => $params,
            RequestOptions::HEADERS     => [
                'Key'          => $this->apiKey->getApiKey(),
                'Sign'         => hash_hmac('sha512', $data, $this->apiKey->getSecret()),
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
        ];

        $response = parent::request($command, $params);
        $this->apiKey = null;

        return $response;
    }

    /**
     * Set Api key
     *
     * @param ApiKey $apiKey
     *
     * @return TradingApi
     */
    public function setApiKey(ApiKey $apiKey): self
    {
        $this->apiKey = $apiKey;

        return $this;
    }

    /**
     * Returns all of your available balances.
     *
     * @return Balance
     */
    public function returnBalances(): Balance
    {
        $balance = new Balance();
        foreach ($this->request('returnBalances') as $currency => $value) {
            $balance->currencies[$currency] = $value;
        }

        return $balance;
    }

    /**
     * Returns all of your balances, including available balance, balance on orders, and the
     * estimated BTC value of your balance. By default, this call is limited to your exchange
     * account; set the "account" POST parameter to "all" to include your margin and lending accounts.
     *
     * Array keys are 3-digit coin codes
     *
     * @param  string $account
     * @return CompleteBalance[]
     */
    public function returnCompleteBalances(string $account = null): array
    {
        $balances = [];
        foreach ($this->request('returnCompleteBalances', compact('account')) as $coin => $balance) {
            $balances[$coin] = $this->factory(CompleteBalance::class, $balance);
        }

        return $balances;
    }

    /**
     * Returns all of your deposit addresses.
     *
     * @return DepositAddresses
     */
    public function returnDepositAddresses(): DepositAddresses
    {
        $depositAddresses = new DepositAddresses();
        foreach ($this->request('returnDepositAddresses') as $coin => $address) {
            $depositAddresses->addresses[$coin] = $address;
        }

        return $depositAddresses;
    }

    /**
     * Generates a new deposit address for the currency specified by the "currency" POST parameter.
     * Only one address per currency per day may be generated, and a new address may not be generated
     * before the previously-generated one has been used.
     *
     * @param string $currency 3-digit currency code
     *
     * @return NewAddress
     */
    public function generateNewAddress(string $currency): NewAddress
    {
        /* @var $newAddress NewAddress */
        $newAddress = $this->factory(
            NewAddress::class,
            $this->request('generateNewAddress', compact('currency'))
        );

        return $newAddress;
    }

    /**
     * Returns your deposit and withdrawal history within a range, specified by the "start" and "end" POST parameters,
     * both of which should be given as UNIX timestamps.
     *
     * @param int $start UNIX timestamps
     * @param int $end UNIX timestamps
     *
     * @return DepositsWithdrawals
     */
    public function returnDepositsWithdrawals(int $start, int $end): DepositsWithdrawals
    {
        /** @var $depositsWithdrawals DepositsWithdrawals*/
        $depositsWithdrawals = $this->factory(
            DepositsWithdrawals::class,
            $this->request('returnDepositsWithdrawals', compact('start', 'end'))
        );

        return $depositsWithdrawals;
    }

    /**
     * Returns your open orders for a given market.
     *
     * @param string $currencyPair
     * @return OpenOrder[]
     */
    public function returnOpenOrders(string $currencyPair): array
    {
        $this->throwExceptionIf($currencyPair === 'all', 'Please use TradingApi::returnAllOpenOrders() method');

        $openOrders = [];
        foreach ($this->request('returnOpenOrders', compact('currencyPair')) as $openOrder) {
            $openOrders[] = $this->factory(OpenOrder::class, $openOrder);
        }

        return $openOrders ?? [];
    }

    /**
     * Return open orders for all markets.
     *
     * OpenOrder[][]
     */
    public function returnAllOpenOrders(): array
    {
        $openOrders = [];
        foreach ($this->request('returnOpenOrders', ['currencyPair' => 'all']) as $pair => $orders) {
            if (is_array($orders)) {
                foreach ($orders as $openOrder) {
                    $openOrders[$pair][] = $this->factory(OpenOrder::class, $openOrder);
                }
            }
        }

        return $openOrders;
    }

    /**
     * Returns your trade history for a given market, specified by the "currencyPair" POST parameter.
     *
     * You may optionally specify a range via "start" and/or "end" POST parameters, given in UNIX timestamp format;
     * if you do not specify a range, it will be limited to one day. You may optionally limit the number of entries
     * returned using the "limit" parameter, up to a maximum of 10,000. If the "limit" parameter is not specified,
     * no more than 500 entries will be returned.
     *
     * @param string $currencyPair
     * @param int|null $start UNIX timestamp format
     * @param int|null $end UNIX timestamp format
     * @param int|null $limit
     *
     * @return TradeHistory[]
     */
    public function returnTradeHistory(
        string $currencyPair,
        int $start = null,
        int $end = null,
        int $limit = null
    ): array {

        $this->throwExceptionIf($currencyPair === 'all', 'Please use TradingApi::returnAllTradeHistory() method');

        foreach ($this->request('returnTradeHistory', compact('currencyPair', 'start', 'end', 'limit')) as $history) {
            $tradeHistory[] = $this->factory(TradeHistory::class, $history);
        }

        return $tradeHistory ?? [];
    }

    /**
     * Receive your trade history for all markets.
     * NOTE: Keys of response is currency pair codes like 'BTC_MAID'
     *
     * @param int|null $start
     * @param int|null $end
     * @param int|null $limit
     *
     * @return TradeHistory[][]
     */
    public function returnAllTradeHistory(
        int $start = null,
        int $end = null,
        int $limit = null
    ): array {

        $tradeHistory = [];
        $currencyPair = 'all';
        $response = $this->request('returnTradeHistory', compact('currencyPair', 'start', 'end', 'limit'));

        foreach ($response as $pair => $histories) {
            if (is_array($histories) && !empty($histories)) {
                foreach ($histories as $history) {
                    $tradeHistory[$pair][] = $this->factory(TradeHistory::class, $history);
                }
            }
        }

        return $tradeHistory;
    }

    /**
     * Returns all trades involving a given order, specified by the "orderNumber" POST parameter.
     * If no trades for the order have occurred or you specify an order that does
     * not belong to you, you will receive an error.
     *
     * @param int $orderNumber
     * @return OrderTrade[]
     */
    public function returnOrderTrades(int $orderNumber): array
    {
        $orderTrades = [];
        foreach ($this->request('returnOrderTrades', compact('orderNumber')) as $response) {
            $orderTrades[] = $this->factory(OrderTrade::class, $response);
        }

        return $orderTrades;
    }

    /**
     * Places a buy order in a given market.
     *
     * @param TradeRequest $tradeRequest
     * @return TradeResult
     */
    public function buy(TradeRequest $tradeRequest): TradeResult
    {
        return $this->tradeRequest('buy', $tradeRequest);
    }

    /**
     * Places a sell order in a given market.
     *
     * @param TradeRequest $tradeRequest
     * @return TradeResult
     */
    public function sell(TradeRequest $tradeRequest): TradeResult
    {
        return $this->tradeRequest('sell', $tradeRequest);
    }

    /**
     * Returns the status of a given order, specified by the "orderNumber" POST parameter.
     * If the specified orderNumber is not open, or it is not yours, you will receive an error.
     *
     * Note that returnOrderStatus, in concert with returnOrderTrades,
     * can be used to determine various status information about an order:
     *
     * 1) If returnOrderStatus returns status: "Open", the order is fully open.
     * 2) If returnOrderStatus returns status: "Partially filled", the order is partially filled,
     *    and returnOrderTrades may be used to find the list of those fills.
     * 3) If returnOrderStatus returns an error and returnOrderTrades returns an error,
     *    then the order was cancelled before it was filled.
     * 4) If returnOrderStatus returns an error and returnOrderTrades returns a list of trades, then the order
     *    had fills and is no longer open (due to being completely filled, or partially filled and then cancelled).
     *
     * @param int $orderNumber
     *
     * @return OrderStatus
     *
     * @throws \Poloniex\Exception\PoloniexException
     */
    public function returnOrderStatus(int $orderNumber): OrderStatus
    {
        $response = $this->request('returnOrderStatus', compact('orderNumber'));

        $message = 'Unable to return order status';
        $this->throwExceptionIf((int) $response['success'] === 0, $message);
        $this->throwExceptionIf(!isset($response['result'][$orderNumber]), $message);

        /** @var $orderStatus OrderStatus */
        $orderStatus = $this->factory(
            OrderStatus::class,
            $response['result'][$orderNumber]
        );

        return $orderStatus;
    }

    /**
     * Cancels an order you have placed in a given market.
     * Required POST parameter is "orderNumber".
     * If successful, the method will return: {"success":1}
     *
     * @param int $orderNumber
     * @return bool
     */
    public function cancelOrder(int $orderNumber): bool
    {
        $response = $this->request('cancelOrder', compact('orderNumber'));

        return isset($response['success']) ? (bool) $response['success'] : false;
    }

    /**
     * Cancels an order and places a new one of the same type in a single atomic
     * transaction, meaning either both operations will succeed or both will fail.
     * Required POST parameters are "orderNumber" and "rate"; you may optionally
     * specify "amount" if you wish to change the amount of the new order.
     *
     * "postOnly" or "immediateOrCancel" may be specified for exchange orders,
     * but will have no effect on margin orders.
     *
     * @param MoveOrderRequest $moveOrderRequest
     * @return MoveOrder
     */
    public function moveOrder(MoveOrderRequest $moveOrderRequest): MoveOrder
    {
        foreach (['orderNumber', 'rate'] as $requiredField) {
            $this->throwExceptionIf(
                $moveOrderRequest->{$requiredField} === null,
                sprintf('Unable to send "moveOrder" request. Field "%s" should be set.', $requiredField)
            );
        }

        /** @var $moveOrder MoveOrder */
        $moveOrder = $this->factory(
            MoveOrder::class,
            $this->request('moveOrder', get_object_vars($moveOrderRequest))
        );

        return $moveOrder;
    }

    /**
     * Immediately places a withdrawal for a given currency, with no email confirmation.
     * In order to use this method, the withdrawal privilege must be enabled for your API key.
     * Required POST parameters are "currency", "amount", and "address".
     * For XMR withdrawals, you may optionally specify "paymentId".
     *
     * @param string $currency
     * @param string $amount
     * @param string $address
     * @param int|null $paymentId
     *
     * @return string
     */
    public function withdraw(string $currency, string $amount, string $address, int $paymentId = null): string
    {
        $response = $this->request('withdraw', compact('currency', 'amount', 'address', 'paymentId'));

        return $response['response'] ?? 'Failed withdraw request.';
    }

    /**
     * If you are enrolled in the maker-taker fee schedule, returns your current trading fees
     * and trailing 30-day volume in BTC. This information is updated once every 24 hours.
     *
     * @return FeeInfo
     */
    public function returnFeeInfo(): FeeInfo
    {
        /** @var $feeInfo FeeInfo */
        $feeInfo = $this->factory(
            FeeInfo::class,
            $this->request('returnFeeInfo')
        );

        return $feeInfo;
    }

    /**
     * Returns your balances sorted by account. You may optionally specify the "account" POST parameter
     * if you wish to fetch only the balances of one account. Please note that balances in your margin
     * account may not be accessible if you have any open margin positions or orders.
     *
     * @param string|null $account
     * @return AvailableAccountBalances
     */
    public function returnAvailableAccountBalances(string $account = null): AvailableAccountBalances
    {
        $this->throwExceptionIf(
            $account !== null && !property_exists(AvailableAccountBalances::class, $account),
            sprintf('Invalid account type "%s" given', $account)
        );

        /* @var $availableAccountBalances AvailableAccountBalances */
        $availableAccountBalances = $this->factory(
            AvailableAccountBalances::class,
            $this->request('returnAvailableAccountBalances', compact('account'))
        );

        return $availableAccountBalances;
    }

    /**
     * Returns your current tradable balances for each currency in each market for which margin trading is enabled.
     * Please note that these balances may vary continually with market conditions. Sample output:
     *
     * "BTC_DASH" => [
     *      "BTC" => "8.50274777",
     *      "DASH":"654.05752077",
     * ], "BTC_LTC" => [
     *      "BTC" => "8.50274777",
     *      "LTC":"1214.67825290"
     * ],"BTC_XMR" => [
     *      "BTC" => "8.50274777",
     *      "XMR" => "3696.84685650"
     * ]
     *
     * @return array
     */
    public function returnTradableBalances(): array
    {
        return $this->request('returnTradableBalances');
    }

    /**
     * Transfers funds from one account to another (e.g. from your exchange account to your margin account).
     *
     * @param string $currency
     * @param float $amount
     * @param string $fromAccount
     * @param string $toAccount
     *
     * @return SampleResponse
     */
    public function transferBalance(
        string $currency,
        float $amount,
        string $fromAccount,
        string $toAccount
    ): SampleResponse {
        /* @var $response SampleResponse */
        $response = $this->factory(
            SampleResponse::class,
            $this->request('transferBalance', compact('currency', 'amount', 'fromAccount', 'toAccount'))
        );

        return $response;
    }

    /**
     * Returns a summary of your entire margin account. This is the same information you will find in the
     * Margin Account section of the Margin Trading page, under the Markets list.
     *
     * @return MarginAccountSummary
     */
    public function returnMarginAccountSummary(): MarginAccountSummary
    {
        /* @var $marginAccountSummary MarginAccountSummary */
        $marginAccountSummary = $this->factory(
            MarginAccountSummary::class,
            $this->request('returnMarginAccountSummary')
        );

        return $marginAccountSummary;
    }

    /**
     * Places a margin buy order in a given market.
     * You may optionally specify a maximum lending rate using the "lendingRate" parameter.
     * If successful, the method will return the order number and any trades immediately resulting from your order.
     *
     * @param string $currencyPair
     * @param float  $rate
     * @param float  $amount
     * @param float  $lendingRate
     *
     * @return MarginTrade
     */
    public function marginBuy(string $currencyPair, float $rate, float $amount, float $lendingRate = null): MarginTrade
    {
        return $this->marginTrade('marginBuy', compact('currencyPair', 'rate', 'amount', 'lendingRate'));
    }

    /**
     * Places a margin sell order in a given market.
     * Parameters and output are the same as for the marginBuy method.
     *
     * @param string     $currencyPair
     * @param float      $rate
     * @param float      $amount
     * @param float|null $lendingRate
     *
     * @return MarginTrade
     */
    public function marginSell(string $currencyPair, float $rate, float $amount, float $lendingRate = null): MarginTrade
    {
        return $this->marginTrade('marginSell', compact('currencyPair', 'rate', 'amount', 'lendingRate'));

    }

    /**
     * Returns information about your margin position in a given market.
     *
     * You may set "currencyPair" to "all" if you wish to fetch all of your margin positions at once.
     * If you have no margin position in the specified market, "type" will be set to "none".
     * "liquidationPrice" is an estimate, and does not necessarily represent the price at which an
     * actual forced liquidation will occur. If you have no liquidation price, the value will be -1.
     *
     * @param string $currencyPair
     * @return MarginPosition
     */
    public function getMarginPosition(string $currencyPair = 'all'): MarginPosition
    {
        /* @var $marginPosition MarginPosition */
        $marginPosition = $this->factory(
            MarginPosition::class,
            $this->request('getMarginPosition', compact('currencyPair'))
        );

        return $marginPosition;
    }

    /**
     * Closes your margin position in a given market using a market order.
     * This call will also return success if you do not have an open position in the specified market.
     *
     * @param string $currencyPair
     * @return CloseMarginPosition
     */
    public function closeMarginPosition(string $currencyPair): CloseMarginPosition
    {
        $response = $this->request('closeMarginPosition', compact('currencyPair'));

        $closeMarginPosition = new CloseMarginPosition();
        $closeMarginPosition->success = (bool) $response['success'];
        $closeMarginPosition->message = $response['message'];

        $responseResultingTrades = $response['resultingTrades'] ?? [];

        /* @var $resultingTrades array */
        foreach ($responseResultingTrades as $pair => $resultingTrades) {
            foreach ($resultingTrades as $resultingTrade) {
                $closeMarginPosition->resultingTrades[$pair][] = $this->factory(ResultingTrade::class, $resultingTrade);
            }
        }

        return $closeMarginPosition;
    }

    /**
     * Creates a loan offer for a given currency.
     *
     * @param CreateLoanOfferRequest $request
     * @return CreateLoanOffer
     */
    public function createLoanOffer(CreateLoanOfferRequest $request): CreateLoanOffer
    {
        foreach (get_object_vars($request) as $property => $value) {
            $this->throwExceptionIf(
                $value === null,
                sprintf('Unable to send "moveOrder" request. Field "%s" should be set.', $property)
            );
        }

        /* @var $createLoanOffer CreateLoanOffer */
        $createLoanOffer = $this->factory(
            CreateLoanOffer::class,
            $this->request('createLoanOffer', get_object_vars($request))
        );

        return $createLoanOffer;
    }

    /**
     * Cancels a loan offer specified by the "orderNumber" POST parameter.
     *
     * @param int $orderNumber
     * @return SampleResponse
     */
    public function cancelLoanOffer(int $orderNumber): SampleResponse
    {
        /* @var $response SampleResponse */
        $response = $this->factory(
            SampleResponse::class,
            $this->request('cancelLoanOffer', compact('orderNumber'))
        );

        return $response;
    }

    /**
     * Returns your open loan offers for each currency.
     * NOTE: Keys of result array is currency codes
     *
     * @return Loan[][]
     */
    public function returnOpenLoanOffers(): array
    {
        $openLoanOffers = [];

        /* @var $offers array */
        foreach ($this->request('returnOpenLoanOffers') as $currency => $offers) {
            foreach ($offers as $offer) {
                $openLoanOffers[$currency][] = $this->factory(Loan::class, $offer);
            }
        }

        return $openLoanOffers;
    }

    /**
     * Returns your active loans for each currency
     */
    public function returnActiveLoans(): ActiveLoans
    {
        /* @var $activeLoans ActiveLoans */
        $activeLoans = $this->factory(
            ActiveLoans::class,
            $this->request('returnActiveLoans')
        );

        return $activeLoans;
    }

    /**
     * Returns your lending history within a time range specified by the "start" and "end" POST parameters
     * as UNIX timestamps. "limit" may also be specified to limit the number of rows returned.
     *
     * @param int      $start
     * @param int      $end
     * @param int|null $limit
     *
     * @return LandingHistory[]
     */
    public function returnLendingHistory(int $start, int $end, int $limit = null): array
    {
        $history = [];

        foreach ($this->request('returnLendingHistory', compact('start', 'end', 'limit')) as $data) {
            $history[] = $this->factory(LandingHistory::class, $data);
        }

        return $history;
    }

    /**
     * Toggles the autoRenew setting on an active loan, specified by the "orderNumber" POST parameter.
     * If successful, "message" will indicate the new autoRenew setting.
     *
     * @param int $orderNumber
     *
     * @return SampleResponse
     */
    public function toggleAutoRenew(int $orderNumber): SampleResponse
    {
        /* @var $autoRenew SampleResponse */
        $autoRenew = $this->factory(
            SampleResponse::class,
            $this->request('toggleAutoRenew', compact('orderNumber'))
        );

        return $autoRenew;
    }

    /**
     * Places a limit buy order in a given market. Required POST parameters are "currencyPair", "rate", and "amount".
     * If successful, the method will return the order number.
     *
     * You may optionally set "fillOrKill", "immediateOrCancel", "postOnly" to 1. A fill-or-kill order will either
     * fill in its entirety or be completely aborted. An immediate-or-cancel order can be partially or completely
     * filled, but any portion of the order that cannot be filled immediately will be canceled rather than left on
     * the order book. A post-only order will only be placed if no portion of it fills immediately; this guarantees
     * you will never pay the taker fee on any part of the order that fills.
     *
     * @param string $command
     * @param TradeRequest $tradeRequest
     *
     * @return TradeResult
     */
    protected function tradeRequest(string $command, TradeRequest $tradeRequest): TradeResult
    {
        foreach (['currencyPair', 'rate', 'amount'] as $requiredField) {
            $this->throwExceptionIf(
                $tradeRequest->{$requiredField} === null,
                sprintf('Unable to send "%s" request. Field "%s" should be set.', $command, $requiredField)
            );
        }

        $coin = strtoupper(explode('_', $tradeRequest->currencyPair)[0]);
        $total = $tradeRequest->amount * $tradeRequest->rate;

        if (isset(TradeRequest::MIN_TOTAL[$coin]) && TradeRequest::MIN_TOTAL[$coin] > $total) {
            throw new TotalDeficiencyException(TradeRequest::MIN_TOTAL[$coin], $coin);
        }

        $response = $this->request($command, get_object_vars($tradeRequest));
        $this->throwExceptionIf(!isset($response['orderNumber'], $response['resultingTrades']), 'Poloniex buy error.');

        $buySell = new TradeResult();
        $buySell->orderNumber = (int) $response['orderNumber'];
        $resultingTrades = $response['resultingTrades'] ?? [];

        foreach ($resultingTrades as $trade) {
            $buySell->resultingTrades[] = $this->factory(ResultingTrade::class, $trade);
        }

        return $buySell;
    }

    /**
     * @param string $command
     * @param array  $params
     *
     * @return MarginTrade
     */
    protected function marginTrade(string $command, array $params): MarginTrade
    {
        $response = $this->request($command, $params);

        $marginTrade = new MarginTrade();
        $marginTrade->success = $response['success'] ?? null;
        $marginTrade->message = $response['message'] ?? null;
        $marginTrade->orderNumber = (int) $response['orderNumber'];

        $resultingTrades = $response['resultingTrades'] ?? [];

        /*  @var $trades array */
        foreach ($resultingTrades as $currencyPair => $trades) {
            foreach ($trades as $trade) {
                $marginTrade->resultingTrades[$currencyPair][] = $this->factory(ResultingTrade::class, $trade);
            }
        }

        return $marginTrade;
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequestMethod(): string
    {
        return 'POST';
    }

    /**
     * {@inheritdoc}
     */
    protected function getRequestUri(): string
    {
        return 'tradingApi';
    }

    /**
     * The nonce parameter is an integer which must always be greater than the previous nonce used.
     * Generate a nonce to avoid problems with 32bit systems
     */
    public function getNonce(): int
    {
        $time = explode(' ', microtime());

        return $time[1] . substr($time[0], 2, 6);
    }
}