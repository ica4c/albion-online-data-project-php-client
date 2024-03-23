# Gold prices

`Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient::class`  

### Fetch prices

###### Method
`fetchSellOrderHistory(DateTime $date = null, int $count = null)`

###### Params
* _\DateTime_ `$date` - fetch for date
* _int_ `$count` - result count 

###### Throws
 * _FailedToFetchPriceDataException_ - in case if something went wrong

###### Example

```
use Albion\OnlineDataProject\Domain\Realm;
use Albion\OnlineDataProject\Infrastructure\DataProject\Factories\HttpClientFactory;
use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
 
$realm = Realm::of(Realm::WEST);
 
$client = new GoldPriceClient(
    HttpClientFactory::makeByRealm($realm)
);

// Fetch latest 10 price spots
try {
    $prices = $client->fetchSellOrderHistory(null, 10)->wait();

    // Do something with prices
} catch (\Exception $reason) {
    // Do something in case of exception
}
```