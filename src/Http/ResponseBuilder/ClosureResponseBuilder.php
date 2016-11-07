<?php

namespace Yuloh\JsonGuard\Illuminate\Http\ResponseBuilder;

use Illuminate\Http\Request;
use League\JsonGuard\ValidationError;
use Symfony\Component\HttpFoundation\Response;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;

class ClosureResponseBuilder implements ResponseBuilder
{
    /**
     * @var \Closure
     */
    private $callback;

    /**
     * @param \Closure $callback
     */
    public function __construct(\Closure $callback)
    {
        $this->callback = $callback;
    }

    /**
     * Build an error response.
     *
     * @param Request           $request
     * @param ValidationError[] $errors
     *
     * @return Response
     */
    public function __invoke(Request $request, array $errors) : Response
    {
        return ($this->callback)($request, $errors);
    }
}
