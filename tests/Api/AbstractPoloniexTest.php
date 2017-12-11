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

namespace Poloniex\Tests\Api;

use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Poloniex\CallHistory\RedisCallHistory;
use Poloniex\PoloniexClient;
use Poloniex\Response\ResponseInterface;
use Psr\Log\NullLogger;
use Mockery;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Class AbstractPoloniexTest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
abstract class AbstractPoloniexTest extends TestCase
{
    /**
     * @var PoloniexClient
     */
    protected $poloniexClient;

    /**
     * {@inheritdoc}
     */
    protected function setUp(): void
    {
        $callHistory = Mockery::mock(RedisCallHistory::class);
        $callHistory->shouldReceive('create')->andReturn();
        $callHistory->shouldReceive('isIncreased')->andReturn(false);

        $this->poloniexClient = new PoloniexClient($callHistory, new NullLogger());
    }

    /**
     * Mock Poloniex client with test data
     *
     * @param string $command
     */
    protected function mockPoloniexClient(string $command)
    {
        $this->poloniexClient = Mockery::mock($this->poloniexClient)
            ->shouldReceive('request')
            ->andReturn(new Response(200, [], file_get_contents(sprintf($this->getJsonPath(), $command))))
            ->getMock();
    }

    /**
     * @param string            $command
     * @param ResponseInterface $response
     * @param string            $className
     */
    protected function checkResponse(string $command, ResponseInterface $response, string $className)
    {
        $this->assertInstanceOf($className, $response);
        $this->checkDataResponse($this->getJsonResponse($command), $response);
    }

    /**
     * @param string              $command
     * @param ResponseInterface[] $responses
     * @param string              $className
     */
    protected function checkCollectionResponse(string $command, array $responses, string $className)
    {
        $json = $this->getJsonResponse($command);

        /* @var $data array */
        foreach ($json as $key => $data) {
            $this->assertInstanceOf($className, $responses[$key]);
            $this->checkDataResponse($data, $responses[$key]);
        }
    }

    /**
     * @param array             $json
     * @param ResponseInterface $response
     */
    protected function checkDataResponse(array $json, ResponseInterface $response)
    {
        foreach ($json as $field => $expected) {

            if ($field === 'tradeID') {
                $this->assertTrue(property_exists($response, 'tradeId'));
                $actual = $response->tradeId ?? null;
            } elseif ($field === 'orderID') {
                $this->assertTrue(property_exists($response, 'orderId'));
                $actual = $response->orderId ?? null;
            } elseif ($field === 'globalTradeID') {
                $this->assertTrue(property_exists($response, 'globalTradeId'));
                $actual = $response->globalTradeId ?? null;
            } else {
                $getter = 'get' . ucfirst($field);
                $actual = method_exists($response, $getter)
                    ? $response->{$getter}()
                    : $response->{$field};
            }

            if (\is_bool($actual)) {
                $expected = (bool) $expected;
            }

            $this->assertEquals($expected, $actual);
        }
    }

    /**
     * Get json response in array format
     *
     * @param string $command
     *
     * @return array
     */
    protected function getJsonResponse(string $command): array
    {
        return json_decode(file_get_contents(sprintf($this->getJsonPath(), $command)), true);
    }

    /**
     * @return Serializer
     */
    final protected function getSerializer(): Serializer
    {
        return new Serializer([new ObjectNormalizer()], [new JsonEncoder()]);
    }

    /**
     * Setup response to guzzle client
     *
     * @param string $command
     */
    abstract protected function prepareApi(string $command): void;


    /**
     * Get path for json test files
     *
     * @return string
     */
    abstract protected function getJsonPath(): string;
}