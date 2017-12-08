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

namespace Poloniex\Response;

/**
 * Class ErrorResponse
 * In the event of an error, the response will always be of the following format.
 *
 * @package Poloniex\Exchange\Poloniex\Response
 */
class ErrorResponse extends AbstractResponse
{
    /**
     * Human readable error message
     *
     * @var string
     */
    public $error;
}