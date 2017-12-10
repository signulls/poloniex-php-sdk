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
 * Class MoveOrderRequest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class MoveOrderRequest implements RequestInterface
{
    /**
     * @var int
     */
    public $orderNumber;

    /**
     * @var  float
     */
    public $rate;

    /**
     * @var float
     */
    public $amount;

    /**
     * @var int
     */
    public $postOnly;

    /**
     * @var int
     */
    public $immediateOrCancel;
}