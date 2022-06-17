# установка
```
composer install
```

# запуск через консоль

```
yii constructor dcii
```

# REST API

```
curl -X POST -H "Content-Type: application/json" 
    -d '{"query" : "dcii"}' 
    https://test_work/products
```