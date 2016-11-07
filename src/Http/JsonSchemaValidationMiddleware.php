<?php

namespace Yuloh\JsonGuard\Illuminate\Http;

use Closure;
use Illuminate\Http\Request;
use League\JsonGuard\Validator;
use Symfony\Component\HttpFoundation\Response;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;
use Yuloh\JsonGuard\Illuminate\Contracts\SchemaLoader;

/**
 * A route middleware for validating the request body against a JSON Schema.
 */
class JsonSchemaValidationMiddleware
{
    /**
     * @var SchemaLoader
     */
    private $schemaLoader;

    /**
     * @var ResponseBuilder
     */
    private $responseBuilder;

    /**
     * @param SchemaLoader    $schemaLoader
     * @param ResponseBuilder $responseBuilder
     */
    public function __construct(SchemaLoader $schemaLoader, ResponseBuilder $responseBuilder)
    {
        $this->schemaLoader    = $schemaLoader;
        $this->responseBuilder = $responseBuilder;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  string                   $schema
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next, string $schema) : Response
    {
        $schema    = ($this->schemaLoader)($schema);
        $data      = json_decode($request->getContent());
        $validator = new Validator($data, $schema);

        if ($validator->passes()) {
            return $next($request);
        }

        return ($this->responseBuilder)($request, $validator->errors());
    }
}
