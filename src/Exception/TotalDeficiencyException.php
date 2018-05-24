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

namespace Poloniex\Exception;

/**
 * Class TotalDeficiencyException
 *
 * @package Poloniex\Exception
 */
class TotalDeficiencyException extends PoloniexException
{
    /**
     * TotalDeficiencyException constructor.
     *
     * @param float $total
     * @param string $coin
     */
    public function __construct(float $total, string $coin)
    {
        parent::__construct(sprintf('Total must be at least %s %s', $total, $coin));
    }
}