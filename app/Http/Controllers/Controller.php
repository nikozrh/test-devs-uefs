<?php

namespace App\Http\Controllers;
use OpenApi\Attributes as OA;

#[OA\OpenApi(
    info: new OA\Info(
        version: '1.0.0',
        title: 'API for users, posts , and tag management',
        description: 'Api for the technical test for the Software Engineer position at UEFS',
        termsOfService: 'http://api.example.com/terms',
        contact: new OA\Contact(name: 'API Support', url: 'https://example.com/support', email: 'support@example.com'),
        license: new OA\License(name: 'MIT', url: 'https://opensource.org/licenses/MIT')
    ),
    servers: [
        new OA\Server(url: 'http://localhost:8000/api', description: 'Local server'),
    ],
    tags: [
        new OA\Tag(name: 'Posts', description: 'Operations related to posts'),
        new OA\Tag(name: 'Tags', description: 'Operations related to tags'),
        new OA\Tag(name: 'Users', description: 'Operations related to users'),
    ],
    security: [
        ['bearerAuth' => []]
    ]
)]
#[OA\SecurityScheme(
    type: 'http',
    securityScheme: 'bearerAuth',
    scheme: 'bearer',
    bearerFormat: 'JWT'
)]
#[OA\Schema(
    schema: 'Pagination',
    properties: [
        new OA\Property(property: 'current_page', type: 'integer'),
        new OA\Property(property: 'per_page', type: 'integer'),
        new OA\Property(property: 'total', type: 'integer'),
    ]
)]
abstract class Controller
{
}
