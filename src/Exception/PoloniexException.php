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

namespace Poloniex\Exception;

use Poloniex\Response\ErrorResponse;
use Exception;

/**
 * Class PoloniexException
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class PoloniexException extends Exception
{
    /**
     * Get error response
     *
     * @return ErrorResponse
     */
    public function getErrorResponse(): ErrorResponse
    {
        return new ErrorResponse($this->getMessage());
    }
}