<?php

namespace Yuloh\JsonGuard\Illuminate\Contracts\Http;

use Illuminate\Http\Request;
use League\JsonGuard\ValidationError;
use Symfony\Component\HttpFoundation\Response;

interface ResponseBuilder
{
    /**
     * Build an error response.
     *
     * @param Request           $request
     * @param ValidationError[] $errors
     *
     * @return Response
     */
    public function __invoke(Request $request, array $errors) : Response;
}
