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

class Currency extends AbstractResponse
{
    public const DEPOSIT_ADDRESS_POLONIEX_WALLET = 'poloniexwallet';
    public const DEPOSIT_ADDRESS_POLONIEX = 'poloniex';

    /**
     * Example: 293
     *
     * @var int
     */
    public $id;

    /**
     * Example: "Peercoin"
     *
     * @var string
     */
    public $name;

    /**
     * Example: "0.00500000"
     *
     * @var string
     */
    public $txFee;

    /**
     * Example: 35
     *
     * @var int
     */
    public $minConf;

    /**
     * Example: 1VQpANF1pcKHPRAsZpeyG4jLDd1kbPn32YMeXkr9n8jNFvf8aaJdecB3FyAvo7X1DWJDQt3nii9eUTP5kJSfRpL5AwT72FM
     * Can also contain "poloniex" or "poloniexwallet"
     *
     * @var string|null
     */
    public $depositAddress;

    /**
     * @var bool
     */
    public $disabled;

    /**
     * @var bool
     */
    public $delisted;

    /**
     * @var bool
     */
    public $frozen;

    /**
     * @internal
     * @param bool $disabled
     */
    public function setDisabled(bool $disabled): void
    {
        $this->disabled = $disabled;
    }

    /**
     * @internal
     * @param bool $delisted
     */
    public function setDelisted(bool $delisted): void
    {
        $this->delisted = $delisted;
    }

    /**
     * @internal
     * @param bool $frozen
     */
    public function setFrozen(bool $frozen): void
    {
        $this->frozen = $frozen;
    }
}