# Внутреигровые предметы

`Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient::class`  

### Загрузить последние цены

###### Метод
`fetchActivePrices(array $itemIds, array $locations = null, array $quality = null)`

###### Параметры
* _string[]_ `$itemIds` - идентификаторы предметов
* _Location[]_ `$locations` - идентификаторы локаций
* _ItemQuality[]_ `$quality` - идентификаторы качество

###### Ошибки
 * _FailedToFetchPriceDataException_ - в случае ошибки при загрузке

###### Пример

```
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use Albion\OnlineDataProject\Domain\Location;
use Albion\OnlineDataProject\Domain\ItemQuality;
 
$client = new ItemPriceClient();

// Загрузить последнюю известную цену для т8 щита шедеврального качество в Bridgewatch
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

### История изменения цены

###### Метод
`fetchSellOrderHistory(string $itemId, DateTime $date = null, array $locations = null, array $quality = null, int $timeScale = 1)`

###### Параметры
* _string_ `$itemId` - идентификаторы предметов
* _\DateTime_ `$date` - дата начала отсчета
* _Location[]_ `$locations` - идентификаторы локация
* _ItemQuality[]_ `$quality` - идентификаторы качества
* _int_ `$timeScale` - шаг смещения(в часах)

###### Ошибки
 * _FailedToFetchPriceDataException_ - в случае ошибки при загрузке

###### Пример

```
use Albion\OnlineDataProject\Infrastructure\DataProject\ItemPriceClient;
use Albion\OnlineDataProject\Domain\Location;
use Albion\OnlineDataProject\Domain\ItemQuality;
 
$client = new ItemPriceClient();

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