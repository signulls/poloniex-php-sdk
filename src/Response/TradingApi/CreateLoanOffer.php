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
 * Class CreateLoanOffer
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class CreateLoanOffer extends SampleResponse
{
    /**
     * Example: 10590
     *
     * @var int
     */
    public $orderId;

    /**
     * @internal
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }
}