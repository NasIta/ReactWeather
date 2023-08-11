# Weather-map (React + Yii2)

## Настройка

в `api/config/params-local.php` не забыть вставить api-key от [Сайта с api-погоды](https://openweathermap.org/api).

## Запуск проекта

Всё в докере, поэтому просто:

`docker-compose -f docker-compose.prod.yml up --build --force-recreate --remove-orphans`

(ждем строчку `kachuko.frontend exited with code 0`)

когда запустится, установить зависимости бэка в другой сессии терминала:

`docker exec -i weatherapp.php composer install`

Затем открыть\
[http://localhost:8001](http://localhost:8001) для просмотра в браузере.

## Стоп проекта

### `Ctrl+C`
 `docker-compose -f docker-compose.prod.yml down`