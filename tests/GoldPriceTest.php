<?php

declare(strict_types=1);

namespace Tests;

use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
use DateInterval;
use DateTime;

class GoldPriceTest extends MockedClientTestCase
{
    /**
     * @return array<int, array<int, mixed>>
     */
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
            ],
            [
                Realm::EUROPE,
                null,
                1
            ],
            [
                Realm::EUROPE,
                (new DateTime())->sub(new DateInterval('P1D')),
                1
            ]
        ];
    }

    /**
     * @dataProvider clientDataProvider
     *
     * @param Realm $realm
     * @param DateTime|null $forDate
     * @param int $count
     *
     * @return void
     *
     * @throws \JsonException
     */
    public function testFetchGoldPrices(Realm $realm, ?DateTime $forDate, int $count): void
    {
        $client = new GoldPriceClient(
            $this->mockClient($this->loadResponseSamplesFromSamplesJson('gold_200_responses.json'))
        );

        $prices = $client->fetchSellOrderHistory($realm, $forDate, $count)
            ->wait();

        self::assertIsArray($prices);
    }
}
