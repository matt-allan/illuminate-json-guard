<?php

namespace Yuloh\JsonGuard\Illuminate\Http;

use Illuminate\Http\Request;
use League\JsonGuard\Validator;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;
use Yuloh\JsonGuard\Illuminate\Contracts\SchemaLoader;
use Yuloh\JsonGuard\Illuminate\JsonSchemaValidationException;

trait ValidatesJsonRequests
{
    /**
     * @param Request $request
     * @param string  $schema
     *
     * @throws JsonSchemaValidationException
     *
     * @return void
     */
    public function validateJson(Request $request, string $schema)
    {
        $data      = json_decode($request->getContent());
        $schema    = app(SchemaLoader::class)->__invoke($schema);
        $validator = new Validator($data, $schema);

        if ($validator->passes()) {
            return;
        }

        throw new JsonSchemaValidationException(
            $validator,
            app(ResponseBuilder::class)->__invoke($request, $validator->errors())
        );
    }
}
