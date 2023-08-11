# Weather-map (React + Yii2)

## Настройка

в `api/config/params-local.php` не забыть вставить api-key от [Сайта с api-погоды](https://openweathermap.org/api).

## Запуск проекта

Всё в докере, поэтому просто:

### `docker-compose -f docker-compose.prod.yml up --build --force-recreate --remove-orphans`

Затем открыть\
[http://localhost:8001](http://localhost:8001) to view it in your browser.

##Стоп проекта

### `Ctrl+C`
### `docker-compose -f docker-compose.prod.yml down`