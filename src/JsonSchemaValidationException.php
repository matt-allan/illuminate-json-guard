<?php

namespace Yuloh\JsonGuard\Illuminate;

use League\JsonGuard\Validator;
use Symfony\Component\HttpFoundation\Response;

class JsonSchemaValidationException extends \Exception
{
    /**
     * The validator instance.
     *
     * @var Validator
     */
    private $validator;

    /**
     * The recommended response to send to the client.
     *
     * @var Response
     */
    private $response;

    /**
     * JsonSchemaValidationException constructor.
     *
     * @param Validator $validator
     * @param Response  $response
     */
    public function __construct(Validator $validator, Response $response)
    {
        parent::__construct('The given data failed to pass validation.');

        $this->validator = $validator;
        $this->response  = $response;
    }

    /**
     * @return Validator
     */
    public function getValidator() : Validator
    {
        return $this->validator;
    }

    /**
     * @return Response
     */
    public function getResponse() : Response
    {
        return $this->response;
    }
}
