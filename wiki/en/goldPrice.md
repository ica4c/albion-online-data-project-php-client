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
use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
 
$client = new GoldPriceClient();

// Fetch latest 10 price spots
try {
    $prices = $client->fetchSellOrderHistory(null, 10)->wait();

    // Do something with prices
} catch (\Exception $reason) {
    // Do something in case of exception
}
```