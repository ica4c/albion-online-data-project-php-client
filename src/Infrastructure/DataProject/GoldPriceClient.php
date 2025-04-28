<?php

declare(strict_types=1);

namespace Albion\OnlineDataProject\Infrastructure\DataProject;

use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions\FailedToFetchPriceDataException;
use DateTime;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use Throwable;

class GoldPriceClient extends AbstractClient
{
    protected const ENDPOINT_GOLD_PRICE = 'api/v2/stats/gold';

    public function fetchSellOrderHistory(
        Realm $realm,
        DateTime $date = null,
        int $count = null
    ): PromiseInterface {
        $query = [];

        if($date) {
            $query['date'] = $date->format('Y-m-d');
        }

        if($count) {
            $query['count'] = max(min($count, 50), 0);
        }

        return $this->httpClient->getAsync(
            $this->endpointUrl($realm, self::ENDPOINT_GOLD_PRICE),
            [
                'query' => $query,
                'decode_content' => 'gzip'
            ]
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
