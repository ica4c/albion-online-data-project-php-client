<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use Albion\OnlineDataProject\Domain\ItemQuality;
use Albion\OnlineDataProject\Domain\Markets;
use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Domain\SmugglersNetworkMarkets;
use Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions\FailedToFetchPriceDataException;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Throwable;

class ItemPriceClient extends AbstractClient
{
    protected const ITEM_PRICE_ENDPOINT = "api/v2/stats/prices";
    protected const ITEM_PRICE_HISTORY_ENDPOINT = 'api/v2/stats/history';

    /**
     * @param Realm $realm
     * @param array<array-key, string> $itemIds
     * @param array<array-key, Markets|SmugglersNetworkMarkets>|null $locations
     * @param array<array-key, ItemQuality>|null $qualities
     *
     * @return PromiseInterface
     */
    public function fetchActivePrices(
        Realm $realm,
        array $itemIds,
        array $locations = null,
        array $qualities = null
    ): PromiseInterface {
        $query = [];

        if($locations) {
            $query['locations'] = implode(
                ',',
                array_map(
                    static fn (Markets $market) => $market->value,
                    $locations
                )
            );
        }

        if($qualities) {
            $query['qualities'] = implode(
                ',',
                array_map(
                    static fn (ItemQuality $quality) => $quality->value,
                    $qualities
                )
            );
        }

        return $this->httpClient->getAsync(
            $this->endpointUrl(
                $realm,
                sprintf('%s/%s', self::ITEM_PRICE_ENDPOINT, implode(',', $itemIds))
            ),
            [
                'query' => $query,
                'decode_content' => 'gzip'
            ]
        )
            ->otherwise(
                static function (RequestException $reason) {
                    throw new FailedToFetchPriceDataException($reason);
                }
            )
            ->then(
                static function (Response $response) {
                    return json_decode($response->getBody()->getContents(), true);
                }
            );
    }

    /**
     * @param Realm $realm
     * @param string $itemId
     * @param DateTime|null $date
     * @param array<array-key, Markets>|null $locations
     * @param array<array-key, ItemQuality>|null $qualities
     * @param int $timeScale
     *
     * @return PromiseInterface
     */
    public function fetchSellOrderHistory(
        Realm $realm,
        string $itemId,
        DateTime $date = null,
        array $locations = null,
        array $qualities = null,
        int $timeScale = 1
    ): PromiseInterface {
        $query = [
            'time-scale' => $timeScale
        ];

        if($date) {
            $query['date'] = $date->format('Y-m-d');
        }

        if ($locations) {
            $query['locations'] = implode(
                ',',
                array_map(
                    static fn (Markets $market) => $market->value,
                    $locations
                )
            );
        }

        if ($qualities) {
            $query['quality'] = implode(
                ',',
                array_map(
                    static fn (ItemQuality $quality) => $quality->value,
                    $qualities
                )
            );
        }

        return $this->httpClient->getAsync(
            $this->endpointUrl(
                $realm,
                self::ITEM_PRICE_HISTORY_ENDPOINT . "/" . $itemId,
            ),
            ['query' => $query]
        )
            ->otherwise(
                static function (Throwable $reason) {
                    throw new FailedToFetchPriceDataException($reason);
                }
            )
            ->then(
                static function (Response $response) {
                    return json_decode($response->getBody()->getContents(), true);
                }
            );
    }
}
