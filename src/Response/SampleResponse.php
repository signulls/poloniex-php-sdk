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
 * Class SampleResponse
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class SampleResponse extends AbstractResponse
{
    /**
     * Operation successful or not
     *
     * @var bool
     */
    public $success;

    /**
     * Human readable text
     *
     * @var string
     */
    public $message;

    /**
     * @internal
     * @param bool $success
     */
    public function setSuccess(bool $success)
    {
        $this->success = $success;
    }
}