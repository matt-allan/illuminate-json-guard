<?php

namespace Yuloh\IlluminateJsonGuard\Http\ResponseBuilder;

use Illuminate\Http\Request;
use League\JsonGuard\ValidationError;
use Neomerx\JsonApi\Contracts\Http\ResponsesInterface;
use Neomerx\JsonApi\Document\Error;
use Symfony\Component\HttpFoundation\Response;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;
use Yuloh\JsonGuard\Illuminate\ErrorMessageTranslator;

class NeomerxJsonApiResponseBuilder implements ResponseBuilder
{
    /**
     * @var ErrorMessageTranslator
     */
    private $translator;

    /**
     * @var ResponsesInterface
     */
    private $responder;

    /**
     * @param ErrorMessageTranslator $translator
     * @param ResponsesInterface     $responder
     */
    public function __construct(ErrorMessageTranslator $translator, ResponsesInterface $responder)
    {
        $this->translator = $translator;
        $this->responder  = $responder;
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
        $errors = $this->formatErrors($errors);

        return $this->responder->getErrorResponse($errors, 422);
    }

    /**
     * @param ValidationError[] $errors
     *
     * @return array
     */
    private function formatErrors(array $errors)
    {
        return array_map(function (ValidationError $error) {
            return new Error(
                null, // id
                null, // about
                '422', // status
                'ERR_' . strtoupper($error->getKeyword()), // code
                $this->translator->translate($error), // title
                null, // detail
                [
                    'pointer' => $error->getPointer() // source
                ],
                [
                    'context' => $error->getContext() // meta
                ]
            );
        }, $errors);
    }
}
