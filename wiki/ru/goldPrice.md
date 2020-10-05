# Цены золота

`Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient::class`  

### Загрузить цены

###### Метод
`fetchSellOrderHistory(DateTime $date = null, int $count = null)`

###### Параметры
* _\DateTime_ `$date` - ограничить датой
* _int_ `$count` - ограничить количество результатов

###### Ошибки
 * _FailedToFetchPriceDataException_ - в случае ошибки загрузки

###### Пример

```
use Albion\OnlineDataProject\Infrastructure\DataProject\GoldPriceClient;
 
$client = new GoldPriceClient();

// Загрузить последние 10 спотов
try {
    $prices = $client->fetchSellOrderHistory(null, 10)->wait();

    // Do something with prices
} catch (\Exception $reason) {
    // Do something in case of exception
}
```