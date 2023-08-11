<?php

namespace api\routing;

use OpenApi\Attributes\Items;
use OpenApi\Attributes\JsonContent;
use OpenApi\Attributes\Property;
use OpenApi\Attributes\Response;

#[Response(
    response: 500,
    description: 'Внутренняя ошибка сервера',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: false),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string', nullable: true),
            new Property(property: 'message', type: 'string', nullable: true)
        ]))
    ])
)]
#[Response(
    response: 409,
    description: 'Ошибки логики',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: false),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string', nullable: true),
            new Property(property: 'message', type: 'string', nullable: true)
        ]))
    ])
)]
#[Response(
    response: 403,
    description: 'Отказано в доступе',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: false),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string', nullable: true),
            new Property(property: 'message', type: 'string', nullable: true)
        ]))
    ])
)]
#[Response(
    response: 401,
    description: 'Ошибка авторизации',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: false),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string', nullable: true),
            new Property(property: 'message', type: 'string', nullable: true)
        ]))
    ])
)]
#[Response(
    response: 400,
    description: 'Ошибки валидации',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: false),
        new Property(property: 'errors', type: 'array', items: new Items(properties: [
            new Property(property: 'type', type: 'string', nullable: true),
            new Property(property: 'message', type: 'string', nullable: true),
            new Property(property: 'attribute', type: 'string', nullable: true)
        ]))
    ])
)]
#[Response(
    response: 'return-id',
    description: 'OK',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: true),
        new Property(property: 'data', properties: [
            new Property(property: 'id', type: 'number')
        ])
    ])
)]
#[Response(
    response: 'return-success',
    description: 'OK',
    content: new JsonContent(properties: [
        new Property(property: 'success', type: 'boolean', default: true)
    ])
)]
final class PredefinedResponses
{
    private function __construct() {}
}
