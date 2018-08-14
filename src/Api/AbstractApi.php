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

use GuzzleHttp\RequestOptions;
use Poloniex\PoloniexClient;
use Poloniex\Exception\PoloniexException;
use Symfony\Component\Serializer\{Serializer, SerializerAwareInterface, SerializerInterface};

/**
 * Class AbstractApi
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
abstract class AbstractApi implements ApiInterface, SerializerAwareInterface
{
    use Traits\ResponseFactoryTrait;

    /**
     * Proxy address
     *
     * @var string|null
     */
    protected $proxy;

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
     * Set proxy
     *
     * @param string|null $proxy
     */
    public function setProxy(string $proxy = null): void
    {
        $this->proxy = $proxy;
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
        if (isset($params['currencyPair']) && $params['currencyPair'] !== 'all') {
            $this->checkPair($params['currencyPair'], $command);
        }

        if ($this->proxy !== null) {
            $this->options[RequestOptions::PROXY] = $this->proxy;
        }

        $contents = $this->client
            ->request(
                $this->getRequestMethod(),
                $this->getRequestUri(),
                $this->options
            )
            ->getBody()
            ->getContents();

        $this->proxy = null;
        $response = json_decode($contents ?: '{}', true) ?: [];
        $this->throwExceptionIf(isset($response['error']), $response['error'] ?? 'Poloniex API unknown error.');

        return $response;
    }

    /**
     * Check currency pair
     *
     * @param string $currencyPair
     * @param string $command
     */
    final protected function checkPair(string $currencyPair, string $command)
    {
        $pair = explode('_', $currencyPair);

        $this->throwExceptionIf(
            $pair[0] === $pair[1],
            sprintf('Unable to call "%s" with currency pair %s.', $command, $currencyPair)
        );
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