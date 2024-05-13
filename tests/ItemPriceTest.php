<?php

declare(strict_types=1);

namespace Tests;

use Albion\OnlineDataProject\Domain\ItemQuality;
use Albion\OnlineDataProject\Domain\Markets;
use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use DateInterval;
use DateTime;

class ItemPriceTest extends MockedClientTestCase
{
    /**
     * @return array<int, mixed>
     */
    public function itemDataProvider(): array
    {
        return [
            [
                Realm::WEST,
                ['T7_BAG', 'T8_BAG'],
                Markets::cases(),
                ItemQuality::cases()
            ],
            [
                Realm::EAST,
                ['T7_BAG', 'T8_BAG'],
                Markets::cases(),
                ItemQuality::cases()
            ],
            [
                Realm::EUROPE,
                ['T7_BAG', 'T8_BAG'],
                Markets::cases(),
                ItemQuality::cases()
            ],
        ];
    }

    /**
     * @dataProvider itemDataProvider
     *
     * @param Realm $realm
     * @param array<int, string> $item_ids
     * @param array<int, Markets> $locations
     * @param array<int, ItemQuality> $qualities
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function testItemActivePrice(
        Realm $realm,
        array $item_ids,
        array $locations,
        array $qualities
    ): void {
        $client = new ItemPriceClient(
            $this->mockClient($this->loadResponseSamplesFromSamplesJson('item_prices_200_responses.json'))
        );

        $prices = $client->fetchActivePrices(
            $realm,
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
     * @param Realm $realm
     * @param array<int, string> $item_ids
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function testItemHistoricalPrices(
        Realm $realm,
        array $item_ids
    ): void {
        $client = new ItemPriceClient(
            $this->mockClient(
                $this->loadResponseSamplesFromSamplesJson('item_prices_historical_200_responses.json')
            )
        );

        /** @var string $item_id */
        $item_id = current($item_ids);

        $prices = $client->fetchSellOrderHistory($realm, $item_id)
            ->wait();

        self::assertIsArray($prices);
    }

    /**
     * @dataProvider itemDataProvider
     *
     * @param Realm $realm
     * @param array<int, string> $item_ids
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function testItemYesterdayPrices(
        Realm $realm,
        array $item_ids
    ): void {
        $client = new ItemPriceClient(
            $this->mockClient($this->loadResponseSamplesFromSamplesJson('item_prices_200_responses.json'))
        );

        /** @var string $item_id */
        $item_id = current($item_ids);

        $prices = $client->fetchSellOrderHistory(
            $realm,
            $item_id,
            (new DateTime())->sub(new DateInterval('P1D'))
        )
            ->wait();

        self::assertIsArray($prices);
    }
}
