# Item prices

`Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient::class`  

### Fetch latest prices

###### Method
`fetchActivePrices(array $itemIds, array $locations = null, array $quality = null)`

###### Params
* _string[]_ `$itemIds` - in-game item ids
* _Location[]_ `$locations` - Location ids
* _ItemQuality[]_ `$quality` - Quality list 

###### Throws
 * _FailedToFetchPriceDataException_ - in case if something went wrong

###### Example

```
use Albion\OnlineDataProject\Domain\Location;
use Albion\OnlineDataProject\Domain\ItemQuality;
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use Albion\OnlineDataProject\Infrastructure\DataProject\Factories\HttpClientFactory;
 
$realm = Realm::of(Realm::WEST); 

$client = new ItemPriceClient(
    HttpClientFactory::makeByRealm($realm)
);

// Fetch last known price for t8 shield masterpiece quality in Bridgewatch
try {
    $prices = $client->fetchActivePrices(
        [
            'T8_SHIELD'
        ], 
        [
            Location::of(Location::BRIDGEWATCH)
        ],
        [
            ItemQuality::of(ItemQuality::MASTERPIECE)
        ]
    )->wait();

    // Do something with prices
} catch (\Exception $reason) {
    // Do something in case of exception
}
```

### Fetch historical prices

###### Method
`fetchSellOrderHistory(string $itemId, DateTime $date = null, array $locations = null, array $quality = null, int $timeScale = 1)`

###### Params
* _string_ `$itemId` - in-game item ids
* _\DateTime_ `$date` - Start date
* _Location[]_ `$locations` - Location ids array
* _ItemQuality[]_ `$quality` - Quality array
* _int_ `$timeScale` - Spot step(in hours)

###### Throws
 * _FailedToFetchPriceDataException_ - in case if something went wrong

###### Example

```
use Albion\OnlineDataProject\Domain\Location;
use Albion\OnlineDataProject\Domain\ItemQuality;
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use Albion\OnlineDataProject\Infrastructure\DataProject\Factories\HttpClientFactory;
 
$realm = Realm::of(Realm::WEST); 

$client = new ItemPriceClient(
    HttpClientFactory::makeByRealm($realm)
);

// Fetch hour price spots for t8 shield masterpiece quality in Bridgewatch and Thetford 5 days ago
try {
    $spots = $client->fetchSellOrderHistory(
        'T8_SHIELD',
        new \DateTime()->sub(new \DateInterval('P5D')) ,
        [
            Location::of(Location::BRIDGEWATCH),
            Location::of(Location::THETFORD)
        ],
        [
            ItemQuality::of(ItemQuality::MASTERPIECE)
        ],
        1
    )->wait();

    // Do something with spots
} catch (\Exception $reason) {
    // Do something in case of exception
}
```