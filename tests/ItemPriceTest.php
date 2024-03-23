<?php

namespace Tests;

use Albion\OnlineDataProject\Domain\ItemQuality;
use Albion\OnlineDataProject\Domain\Markets;
use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\Factories\HttpClientFactory;
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use DateInterval;
use DateTime;
use PHPUnit\Framework\TestCase;
use Solid\Foundation\Exceptions\InvalidEnumValueException;

class ItemPriceTest extends TestCase
{
    public function itemDataProvider(): array
    {
        return [
            [
                Realm::WEST,
                ['T7_BAG', 'T8_BAG'],
                Markets::options(),
                ItemQuality::options()
            ],
            [
                Realm::EAST,
                ['T7_BAG', 'T8_BAG'],
                Markets::options(),
                ItemQuality::options()
            ],
        ];
    }

    /**
     * @dataProvider itemDataProvider
     *
     * @param string $realm
     * @param array $item_ids
     * @param array $locations
     * @param array $qualities
     *
     * @return void
     *
     * @throws InvalidEnumValueException
     */
    public function testItemActivePrice(
        string $realm,
        array $item_ids,
        array $locations,
        array $qualities
    ): void {
        $client = new ItemPriceClient(
            HttpClientFactory::makeByRealm(Realm::of($realm))
        );

        $prices = $client->fetchActivePrices(
            $item_ids,
            $locations,
            $qualities
        )
            ->wait();

        self::assertIsArray($prices);
    }

    /**
     * @dataProvider itemDataProvider
     *
     * @param string $realm
     * @param array $item_ids
     *
     * @return void
     *
     * @throws InvalidEnumValueException
     */
    public function testItemHistoricalPrices(
        string $realm,
        array $item_ids
    ): void {
        $client = new ItemPriceClient(
            HttpClientFactory::makeByRealm(Realm::of($realm))
        );

        $item_id = current($item_ids);

        $prices = $client->fetchSellOrderHistory($item_id)
            ->wait();

        self::assertIsArray($prices);
    }

    /**
     * @dataProvider itemDataProvider
     *
     * @param string $realm
     * @param array $item_ids
     *
     * @return void
     *
     * @throws InvalidEnumValueException
     */
    public function testItemYesterdayPrices(
        string $realm,
        array $item_ids
    ): void {
        $client = new ItemPriceClient(
            HttpClientFactory::makeByRealm(Realm::of($realm))
        );

        $item_id = current($item_ids);

        $prices = $client->fetchSellOrderHistory(
            $item_id,
            (new DateTime)->sub(new DateInterval('P1D'))
        )
            ->wait();

        self::assertIsArray($prices);
    }
}