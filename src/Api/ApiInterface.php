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

use Poloniex\Exception\PoloniexException;

/**
 * Interface ApiInterface
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
interface ApiInterface
{
    /**
     * Call request
     *
     * @param string $command
     * @param array $params
     *
     * @return array
     * @throws PoloniexException
     */
    public function request(string $command, array $params = []): array;
}