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

namespace Poloniex\Response;

/**
 * In the event of an error, the response will always be of the following format.
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class ErrorResponse extends AbstractResponse
{
    /**
     * Human readable error message
     *
     * @var string
     */
    public $error;

    /**
     * ErrorResponse constructor.
     *
     * @param string $error
     */
    public function __construct(string $error = null)
    {
        $this->error = $error;
    }
}