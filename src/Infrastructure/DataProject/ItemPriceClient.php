<?php

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions\FailedToFetchPriceDataException;
use DateTime;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Iterator;

class ItemPriceClient extends AbstractClient
{
    /**
     * @param string[]   $itemIds
     * @param array|null $locations
     * @param array|null $quality
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchActivePrices(array $itemIds,
                                      array $locations = null,
                                      array $quality = null): PromiseInterface
    {
        $query = [];

        if($locations) {
            $query['locations'] = implode(',', $locations);
        }

        if($quality) {
            $query['qualities'] = implode(',', $quality);
        }

        return $this->httpClient->getAsync(
            sprintf('stats/prices/%s', implode(',', $itemIds)),
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
     * @param \Albion\OnlineDataProject\Domain\Location[]|null     $locations
     * @param \Albion\OnlineDataProject\Domain\ItemQuality[]|null     $quality
     * @param int            $timeScale
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchSellOrderHistory(string $itemId,
                                          DateTime $date = null,
                                          array $locations = null,
                                          array $quality = null,
                                          int $timeScale = 1): PromiseInterface
    {
        $query = [
            'time-scale' => $timeScale
        ];

        if($date) {
            $query['date'] = $date->format('d-m-Y');
        }

        if($locations) {
            $query['locations'] = implode(',', $locations);
        }

        if($quality) {
            $query['quality'] = implode(',', $quality);
        }

        return $this->httpClient->getAsync(
            "stats/history/${itemId}",
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
}