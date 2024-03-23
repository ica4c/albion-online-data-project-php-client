<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions\FailedToFetchPriceDataException;
use DateTime;
use Exception;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Throwable;

class ItemPriceClient extends AbstractClient
{
    protected const ITEM_PRICE_ENDPOINT = "api/v2/stats/prices";
    protected const ITEM_PRICE_HISTORY_ENDPOINT = 'api/v2/stats/history';

    /**
     * @param string[]   $itemIds
     * @param array|null $locations
     * @param array|null $quality
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchActivePrices(
        array $itemIds,
        array $locations = null,
        array $quality = null
    ): PromiseInterface {
        $query = [];

        if($locations) {
            $query['locations'] = implode(',', $locations);
        }

        if($quality) {
            $query['qualities'] = implode(',', $quality);
        }

        return $this->httpClient->getAsync(
            sprintf('%s/%s', self::ITEM_PRICE_ENDPOINT, implode(',', $itemIds)),
            ['query' => $query]
        )
            ->otherwise(
                static function(RequestException $reason) {
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
     * @param string         $itemId
     * @param \DateTime|null $date
     * @param \Albion\OnlineDataProject\Domain\Markets[]|null     $locations
     * @param \Albion\OnlineDataProject\Domain\ItemQuality[]|null     $quality
     * @param int            $timeScale
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchSellOrderHistory(
        string $itemId,
        DateTime $date = null,
        array $locations = null,
        array $quality = null,
        int $timeScale = 1
    ): PromiseInterface {
        $query = [
            'time-scale' => $timeScale
        ];

        if($date) {
            $query['date'] = $date->format('Y-m-d');
        }

        if($locations) {
            $query['locations'] = implode(',', $locations);
        }

        if($quality) {
            $query['quality'] = implode(',', $quality);
        }

        return $this->httpClient->getAsync(
            self::ITEM_PRICE_HISTORY_ENDPOINT . "/${itemId}",
            ['query' => $query]
        )
            ->otherwise(
                static function(Throwable $reason) {
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