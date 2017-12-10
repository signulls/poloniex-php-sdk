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

namespace Poloniex\Request;

/**
 * Class CreateLoanOfferRequest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class CreateLoanOfferRequest implements RequestInterface
{
    /**
     * @var string
     */
    public $currency;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var float
     */
    public $duration;

    /**
     * @var int
     */
    public $autoRenew;

    /**
     * @var float
     */
    public $lendingRate;
}