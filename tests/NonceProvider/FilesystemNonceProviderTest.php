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

namespace Poloniex\Tests\Api;

use PHPUnit\Framework\TestCase;
use Poloniex\ApiKey;
use Poloniex\NonceProvider\FilesystemNonceProvider;

/**
 * Class FilesystemNonceProviderTest
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class FilesystemNonceProviderTest extends TestCase
{
    private const NONCE_PATH = 'tests';

    /**
     * @var FilesystemNonceProvider
     */
    private $nonceProvider;

    /**
     * @var ApiKey
     */
    private $apiKey;

    /**
     * {@inheritdoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->apiKey = new ApiKey('key', 'secret');
        $this->nonceProvider = new FilesystemNonceProvider(self::NONCE_PATH);
    }

    /**
     * {@inheritdoc}
     */
    protected function tearDown()
    {
        parent::tearDown();

        unlink($this->getFullPath());
    }

    /**
     * Test get
     */
    public function testGet()
    {
        $this->assertFileNotExists($this->getFullPath());
        $this->assertSame(1, $this->nonceProvider->get($this->apiKey));
        $this->assertFileExists($this->getFullPath());

        $this->nonceProvider->increase($this->apiKey);
        $this->assertSame(2, $this->nonceProvider->get($this->apiKey));
        $this->assertFileExists($this->getFullPath());
    }

    /**
     * Get full path for nonce file
     *
     * @return string
     */
    private function getFullPath(): string
    {
        return self::NONCE_PATH . '/' . $this->nonceProvider->generateFilename($this->apiKey);
    }
}
