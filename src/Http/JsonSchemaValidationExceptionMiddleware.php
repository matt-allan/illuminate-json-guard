<?php

namespace Yuloh\JsonGuard\Illuminate\Http;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yuloh\JsonGuard\Illuminate\JsonSchemaValidationException;

/**
 * A middleware to convert JsonSchemaValidationExceptions into responses.
 * This is only useful with Laravel because Lumen will pass exceptions
 * to the handler before they can be caught by a middleware.
 */
class JsonSchemaValidationExceptionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     *
     * @return Response
     */
    public function handle(Request $request, Closure $next) : Response
    {
        try {
            return $next($request);
        } catch (JsonSchemaValidationException $e) {
            return $e->getResponse();
        }
    }
}
