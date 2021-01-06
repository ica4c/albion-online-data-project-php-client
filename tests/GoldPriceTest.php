<?php

namespace Tests;

use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
use DateInterval;
use DateTime;

class GoldPriceTest extends GuzzleTestCase
{
    /** @var \Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient */
    protected $goldPriceClient;

    /**
     * GoldPriceTest constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->goldPriceClient = new GoldPriceClient();
    }

    public function testFetchTodayGoldPrices(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory(new DateTime)
        );

        self::assertIsArray($prices);
        self::assertNotEmpty($prices);
    }

    public function testFetchLatestGoldPrice(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory(null, 1)
        );

        self::assertIsArray($prices);
        self::assertNotEmpty($prices);
    }

    public function testFetchLatestGoldPriceForDate(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory(
                (new DateTime)->sub(new DateInterval('P1D')),
                1
            )
        );

        self::assertIsArray($prices);
        self::assertNotEmpty($prices);
    }

    public function testFetchGoldPrices(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory()
        );

        self::assertIsArray($prices);
        self::assertNotEmpty($prices);
    }
}