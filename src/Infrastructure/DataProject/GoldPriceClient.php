<?php


namespace Albion\OnlineDataProject\Infrastructure\DataProject;


use Albion\OnlineDataProject\Infrastructure\DataProject\Exceptions\FailedToFetchPriceDataException;
use DateTime;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;

class GoldPriceClient extends AbstractClient
{
    /**
     * @param \DateTime|null $date
     * @param int|null       $count
     *
     * @return \GuzzleHttp\Promise\PromiseInterface
     */
    public function fetchSellOrderHistory(DateTime $date = null,
                                          int $count = null): PromiseInterface
    {
        $query = [];

        if($date) {
            $query['date'] = $date->format('d-m-Y');
        }

        if($count) {
            $query['count'] = max(min($count, 50), 0);
        }

        return $this->httpClient->getAsync(
            "https://www.albion-online-data.com/api/v2/stats/gold",
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