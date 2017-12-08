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

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;

class ChartData extends AbstractResponse
{
    /**
     * Example: 1511032200
     *
     * @var int
     */
    public $date;

    /**
     * Example: 0.01702169
     *
     * @var string
     */
    public $high;

    /**
     * Example: 0.01687201
     *
     * @var string
     */
    public $low;

    /**
     * Example: 0.016912
     *
     * @var string
     */
    public $open;

    /**
     * Example: 0.01699755
     *
     * @var string
     */
    public $close;

    /**
     * Example: 5.33183643
     *
     * @var string
     */
    public $volume;

    /**
     * Example: 314.01492203
     *
     * @var string
     */
    public $quoteVolume;

    /**
     * Example: 0.01697956
     *
     * @var string
     */
    public $weightedAverage;
}