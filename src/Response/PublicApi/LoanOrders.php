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

namespace Poloniex\Response\PublicApi;

use Poloniex\Response\AbstractResponse;
use Poloniex\Response\PublicApi\LoanOrders\{Offer, Demand};

/**
 * Class LoanOrders
 *
 * @author Grisha Chasovskih <chasovskihgrisha@gmail.com>
 */
class LoanOrders extends AbstractResponse
{
    /**
     * @var Offer[]
     */
    public $offers;

    /**
     * @var Demand[]
     */
    public $demands;

    /**
     * @internal
     * @return Offer[]
     */
    public function getOffers(): array
    {
        return $this->offers;
    }

    /**
     * @internal
     * @param Offer[] $offers
     */
    public function setOffers(array $offers): void
    {
        $this->offers = $offers;
    }

    /**
     * @internal
     * @param Offer $offer
     */
    public function addOffer(Offer $offer): void
    {
        $this->offers[] = $offer;
    }

    /**
     * @internal
     * @return Demand[]
     */
    public function getDemands(): array
    {
        return $this->demands;
    }

    /**
     * @internal
     * @param Demand[] $demands
     */
    public function setDemands(array $demands): void
    {
        $this->demands = $demands;
    }

    /**
     * @internal
     * @param Demand $demand
     */
    public function addDemand(Demand $demand): void
    {
        $this->demands[] = $demand;
    }
}