<?php

namespace App\OpenApi;

use ApiPlatform\Core\OpenApi\Factory\OpenApiFactoryInterface;
use ApiPlatform\Core\OpenApi\Model\Operation;
use ApiPlatform\Core\OpenApi\Model\PathItem;
use ApiPlatform\Core\OpenApi\Model\RequestBody;
use ApiPlatform\Core\OpenApi\OpenApi;
use ArrayObject;

class OpenApiFactory implements OpenApiFactoryInterface
{
    public function __construct(private OpenApiFactoryInterface $decorated)
    {
    }

    public function __invoke(array $context = []): OpenApi
    {
        $openApi = $this->decorated->__invoke($context);

        foreach ($openApi->getPaths()->getPaths() as $key =>  $path) {
            if ($path->getGet() && $path->getGet()->getSummary() == 'hidden') {
                $openApi->getPaths()->addPath($key, $path->withGet(null));
            }
        }

        $schemas = $openApi->getComponents()->getSecuritySchemes();
        $schemas['bearerAuth'] = new \ArrayObject([
            'type' => 'http',
            'scheme' => 'bearer',
            'bearerFormat' => 'JWT'
        ]);

        $schemas = $openApi->getComponents()->getSchemas();
        $schemas['Credentials'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'username' => [
                    'type' => 'string',
                    'example' => 'john@doe.fr'
                ],
                'password' => [
                    'type' => 'string',
                    'example' => '123456'
                ],
            ]
        ]);


        $schemas['Token'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],
                'refresh_token' => [
                    'type' => 'string',
                    'readOnly' => true,
                ],

            ]
        ]);

        $schemas['refreshToken'] = new \ArrayObject([
            'type' => 'object',
            'properties' => [
                'refresh_token' => [
                    'type' => 'string',
                ],

            ]
        ]);

        $pathItem = new PathItem(
            post: new Operation(
                operationId: 'postApiLogin',
                tags: ['Auth'],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/Credentials',
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'Token JWT',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ]
                            ]
                        ]
                    ]
                ]
            )
        );
        $pathToken = new PathItem(
            post: new Operation(
                operationId: 'postApiRefreshToken',
                tags: ['Auth'],
                requestBody: new RequestBody(
                    content: new \ArrayObject([
                        'application/json' => [
                            'schema' => [
                                '$ref' => '#/components/schemas/refreshToken',
                            ]
                        ]
                    ])
                ),
                responses: [
                    '200' => [
                        'description' => 'Token JWT',
                        'content' => [
                            'application/json' => [
                                'schema' => [
                                    '$ref' => '#/components/schemas/Token',
                                ]
                            ]
                        ]
                    ]
                ]
            )
        );

        $openApi->getPaths()->addPath('/api/login', $pathItem);
        $openApi->getPaths()->addPath('/api/token/refresh', $pathToken);


        return $openApi;
    }
}
