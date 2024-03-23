<?php

namespace Tests;

use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\Factories\HttpClientFactory;
use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use Solid\Foundation\Exceptions\InvalidEnumValueException;

class GoldPriceTest extends TestCase
{
    public function clientDataProvider(): array
    {
        return [
            [
                Realm::WEST,
                null,
                1
            ],
            [
                Realm::WEST,
                (new DateTime())->sub(new DateInterval('P1D')),
                1
            ],
            [
                Realm::EAST,
                null,
                1
            ],
            [
                Realm::EAST,
                (new DateTime())->sub(new DateInterval('P1D')),
                1
            ]
        ];
    }

    /**
     * @dataProvider clientDataProvider
     *
     * @param string $realm
     * @param DateTime|null $forDate
     * @param int $count
     *
     * @return void
     *
     * @throws InvalidEnumValueException
     */
    public function testFetchGoldPrices(string $realm, ?DateTime $forDate, int $count): void
    {
        $client = new GoldPriceClient(
            HttpClientFactory::makeByRealm(
                Realm::of($realm)
            )
        );

        $prices = $client->fetchSellOrderHistory($forDate, $count)
            ->wait();

        self::assertIsArray($prices);
    }
}