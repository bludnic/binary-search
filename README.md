## find.php
```php
// Поиск по ключу.
echo findRaw('key', 'hashes.txt');
```
## generate.php
```php
// Генерация хэшей в лексикографическом порядке.
// 2684350 - кол-во строк, 4000 - длинна ключа.
echo writeHashes(2684350, 4000, 'hashes.txt');
```
