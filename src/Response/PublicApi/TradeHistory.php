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

use Poloniex\Exception\PoloniexException;
use Poloniex\Response\{AbstractResponse, Traits\DateTrait};

class TradeHistory extends AbstractResponse
{
    use DateTrait;

    public const TYPE_SELL = 'sell';
    public const TYPE_BUY = 'buy';

    private const TYPES = [
        self::TYPE_SELL,
        self::TYPE_BUY,
    ];

    /**
     * Global trade id
     * Example: 263017215
     *
     * @var int
     */
    public $globalTradeID;

    /**
     * Trade id
     * Example: 2909947
     *
     * @var int
     */
    public $tradeID;

    /**
     * Example: "sell" or "buy"
     *
     * @var string
     */
    public $type;

    /**
     * Example: "0.00000887"
     *
     * @var string
     */
    public $rate;

    /**
     * Example: "2565.84864449"
     *
     * @var string
     */
    public $amount;

    /**
     * Example: "0.02275907"
     *
     * @var string
     */
    public $total;

    /**
     * @internal
     * @param string $type
     * @throws PoloniexException
     */
    public function setType(string $type): void
    {
        if (!\in_array($type, self::TYPES, true)) {
            throw new PoloniexException(sprintf('Invalid type %s given', $type));
        }

        $this->type = $type;
    }
}