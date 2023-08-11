<?php

namespace api\routing\routes\content;

use api\routing\RouteInterface;
use OpenApi\Attributes\Get;
use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[Get(
    path: '/api/weather/current-weather',
    description: 'Получить авторизован ли пользователь',
    summary: 'Получить авторизован ли пользователь',
    tags: ['/weather']
)]
#[Response(ref: '#/components/responses/500', response: 500)]
#[Response(ref: '#/components/responses/409', response: 409)]
#[Response(ref: '#/components/responses/400', response: 400)]
#[Response(
    response: 200,
    description: 'OK',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: true),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string'),
            new Property(property: 'message', type: 'string'),
            new Property(property: 'attribute', type: 'string')
        ])),
        new Property(property: 'data', type: 'boolean')
    ])
)]
final class CurrentWeatherRoute implements RouteInterface
{
    public function getRoute(): array
    {
        return ['GET weather/current-weather' => 'weather/current-weather'];
    }
}