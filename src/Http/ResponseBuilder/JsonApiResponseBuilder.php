<?php

namespace Yuloh\JsonGuard\Illuminate\Http\ResponseBuilder;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use League\JsonGuard\ValidationError;
use Symfony\Component\HttpFoundation\Response;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;
use Yuloh\JsonGuard\Illuminate\ErrorMessageTranslator;

class JsonApiResponseBuilder implements ResponseBuilder
{
    /**
     * @var ErrorMessageTranslator
     */
    private $translator;

    /**
     * @param ErrorMessageTranslator $translator
     */
    public function __construct(ErrorMessageTranslator $translator)
    {
        $this->translator = $translator;
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
        return new JsonResponse(
            ['errors' => $this->formatErrors($errors)],
            Response::HTTP_UNPROCESSABLE_ENTITY,
            ['Content-Type' => 'application/vnd.api+json']
        );
    }

    /**
     * @param ValidationError[] $errors
     *
     * @return array
     */
    private function formatErrors(array $errors)
    {
        return array_map(function (ValidationError $error) {
            return [
                'code'   => 'ERR_' . strtoupper($error->getKeyword()),
                'title'  => $this->translator->translate($error),
                'source' => [
                    'pointer' => $error->getPointer()
                ],
                'meta' => [
                    'context' => $error->getContext()
                ]
            ];
        }, $errors);
    }
}
