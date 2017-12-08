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

namespace Poloniex\Api;

use Poloniex\PoloniexClient;
use Poloniex\Exception\PoloniexException;
use Symfony\Component\Serializer\{Serializer, SerializerAwareInterface, SerializerInterface};

abstract class AbstractApi implements ApiInterface, SerializerAwareInterface
{
    use Traits\ResponseFactoryTrait;

    /**
     * @var PoloniexClient
     */
    protected $client;

    /**
     * @var array
     */
    protected $options = [];

    /**
     * AbstractApi constructor.
     *
     * @param PoloniexClient                 $client
     * @param SerializerInterface|Serializer $serializer
     */
    public function __construct(
        PoloniexClient $client,
        SerializerInterface $serializer
    ) {
        $this->setSerializer($serializer);
        $this->client = $client;
    }

    /**
     * Call request
     *
     * @param string $command
     * @param array $params
     *
     * @return array
     * @throws PoloniexException
     */
    public function request(string $command, array $params = []): array
    {
        $contents = $this->client
            ->request(
                $this->getRequestMethod(),
                $this->getRequestUri(),
                $this->options
            )
            ->getBody()
            ->getContents();

        $response = json_decode($contents ?: '{}', true) ?: [];
        $this->throwExceptionIf(isset($response['error']), $response['error'] ?? 'Poloniex API unknown error.');

        return $response;
    }

    /**
     * Get request method
     *
     * @return string GET or POST
     */
    abstract protected function getRequestMethod(): string;

    /**
     * Get request type
     *
     * @return string 'tradingApi' or 'public'
     */
    abstract protected function getRequestUri(): string;
}