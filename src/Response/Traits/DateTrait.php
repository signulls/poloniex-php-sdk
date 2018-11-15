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

namespace Poloniex\Response\Traits;

use DateTime;
use Poloniex\Response\ResponseInterface;

/**
 * Trait DateTrait
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
trait DateTrait
{
    /**
     * Example: "2014-10-18 23:03:21"
     *
     * @var string
     */
    public $date;

    /**
     * @internal
     * @param string $date
     */
    public function setDate(string $date): void
    {
        $this->date = $date;
    }

    /**
     * @internal
     * @param null $format
     * @return string
     */
    public function getDate($format = null): string
    {
        return $format
            ? $this->getDateTime()->format($format)
            : $this->date;
    }

    /**
     * @return DateTime
     */
    public function getDateTime(): DateTime
    {
        return DateTime::createFromFormat(ResponseInterface::DATE_FORMAT, $this->date);
    }
}