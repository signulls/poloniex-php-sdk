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

namespace Poloniex\Response\TradingApi;

use Poloniex\Response\SampleResponse;

/**
 * Class NewAddress
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class NewAddress extends SampleResponse
{
    /**
     * Example: "0xcdb66d2817eedbbe22292291ee4cb77b80a6285d"
     *
     * @var string
     */
    public $response;
}