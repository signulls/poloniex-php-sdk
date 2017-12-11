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

namespace Poloniex\NonceProvider;

use Poloniex\ApiKey;

/**
 * Class FilesystemNonceProvider
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class FilesystemNonceProvider implements NonceProviderInterface, IncreasingNonceInterface
{
    /**
     * Path to the nonce files
     * Do not forget to add this path to .gitignore file
     *
     * @var string
     */
    protected $path;

    /**
     * FilesystemNonceProvider constructor.
     *
     * @param string $path Example: var/cache/nonce
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * {@inheritdoc}
     */
    public function get(ApiKey $apiKey): int
    {
        $filename = $this->path . '/'. $this->generateFilename($apiKey);
        $this->checkNonceFile($filename);

        return (int) file_get_contents($filename);
    }

    /**
     * {@inheritdoc}
     */
    public function increase(ApiKey $apiKey): void
    {
        $filename = $this->path . '/'. $this->generateFilename($apiKey);
        $this->checkNonceFile($filename);

        file_put_contents($filename, (int) file_get_contents($filename) + 1);
    }

    /**
     * Generate specific filename for given ApiKey
     *
     * @param ApiKey $apiKey
     * @return string
     */
    public function generateFilename(ApiKey $apiKey): string
    {
        return md5($apiKey->getApiKey());
    }

    /**
     * Check nonce file exists and if not then create file
     *
     * @param string $filename
     */
    protected function checkNonceFile(string $filename): void
    {
        if (!file_exists($filename)) {
            $file = fopen($filename, 'wb');
            fwrite($file, 1);
            fclose($file);
        }
    }
}