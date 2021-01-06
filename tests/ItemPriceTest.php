<?php

namespace Tests;

use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use DateInterval;
use DateTime;

class ItemPriceTest extends GuzzleTestCase
{
    /** @var \Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient */
    protected $client;

    /**
     * ItemPriceTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->client = new ItemPriceClient();
    }

    public function testItemActivePrice(): void
    {
        $prices = $this->awaitPromise($this->client->fetchActivePrices(['T7_BAG', 'T8_BAG']));

        self::assertIsArray($prices);
    }

    public function testItemHistoricalPrices(): void
    {
        $prices = $this->awaitPromise($this->client->fetchSellOrderHistory('T7_BAG'));

        self::assertIsArray($prices);
    }

    public function testItemYesterdayPrices(): void
    {
        $prices = $this->awaitPromise(
            $this->client->fetchSellOrderHistory(
                'T7_BAG',
                (new DateTime)->sub(new DateInterval('P1D'))
            )
        );

        self::assertIsArray($prices);
    }
}