<?php

namespace Tests;

use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
use DateInterval;
use DateTime;
use GuzzleHttp\Client;

class GoldPriceTest extends GuzzleTestCase
{
    /** @var \Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient */
    protected $goldPriceClient;

    protected function setUp(): void
    {
        parent::setUp();

        $this->goldPriceClient = new GoldPriceClient(
            new Client(['timeout' => 30])
        );
    }


    public function testFetchTodayGoldPrices(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory(new DateTime)
        );

        self::assertIsArray($prices);
    }

    public function testFetchLatestGoldPrice(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory(null, 1)
        );

        self::assertIsArray($prices);
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
    }

    public function testFetchGoldPrices(): void
    {
        $prices = $this->awaitPromise(
            $this->goldPriceClient->fetchSellOrderHistory()
        );

        self::assertIsArray($prices);
    }
}