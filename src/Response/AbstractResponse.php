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
 * Class AbstractResponse
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
abstract class AbstractResponse implements ResponseInterface
{
    /**
     * {@inheritdoc}
     */
    final public function isFailed(): bool
    {
        return static::class instanceof ErrorResponse;
    }
}