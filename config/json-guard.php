<?php

use Yuloh\JsonGuard\Illuminate\Http\ResponseBuilder\JsonApiResponseBuilder;

return [
    'schema'           => base_path('resources/schema.json'),
    'response_builder' => JsonApiResponseBuilder::class,
];
