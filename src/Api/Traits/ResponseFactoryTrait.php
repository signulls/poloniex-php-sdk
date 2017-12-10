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

namespace Poloniex\Api\Traits;

use Poloniex\Exception\PoloniexException;
use Poloniex\Response\ResponseInterface;
use Symfony\Component\Serializer\{Serializer, SerializerInterface};

/**
 * Trait ResponseFactoryTrait
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
trait ResponseFactoryTrait
{
    /**
     * @var Serializer
     */
    protected $serializer;

    /**
     * Sets the serializer.
     *
     * @param SerializerInterface $serializer A SerializerInterface instance
     */
    public function setSerializer(SerializerInterface $serializer): void
    {
        $this->serializer = $serializer;
    }

    /**
     * @param string $responseClass
     * @param array  $data
     *
     * @return ResponseInterface
     */
    protected function factory(string $responseClass, array $data): ResponseInterface
    {
        /* @var $response ResponseInterface */
        $response = $this->serializer->denormalize($data, $responseClass);
        $this->throwExceptionIf(!$response instanceof $responseClass, 'Poloniex response is not valid.');

        if (isset($data['globalTradeID'])) {
            $response->globalTradeId = (int) $data['globalTradeID'];
        }

        if (isset($data['tradeID'])) {
            $response->tradeId = (int) $data['tradeID'];
        }

        if (isset($data['orderID'])) {
            $response->orderId = (int) $data['orderID'];
        }

        return $response;
    }

    /**
     * Throw exception by condition
     *
     * @param bool $condition
     * @param string $message
     *
     * @throws PoloniexException
     */
    protected function throwExceptionIf(bool $condition, string $message): void
    {
        if ($condition) {
            throw new PoloniexException($message);
        }
    }
}