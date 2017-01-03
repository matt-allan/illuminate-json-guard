<?php

namespace Yuloh\JsonGuard\Illuminate\Testing\Concerns;

use League\JsonGuard\ValidationError;
use League\JsonGuard\Validator;
use Yuloh\JsonGuard\Illuminate\Contracts\SchemaLoader;

trait ValidatesJsonResponses
{
    /**
     * The last response returned by the application.
     *
     * @var \Illuminate\Http\Response
     */
    protected $response;

    /**
     * The application instance.
     *
     * @var \Laravel\Lumen\Application
     */
    protected $app;

    /**
     * Assert that the JSON response validates against a schema.
     *
     * @param string $schema
     *
     * @return $this
     */
    public function seeJsonValidatesAgainst(string $schema)
    {
        $data =    json_decode($this->response->getContent());
        $validator = new Validator(
            $data,
            $this->app->make(SchemaLoader::class)->__invoke($schema)
        );

        if ($validator->passes()) {
            return $this;
        }

        $message = implode(PHP_EOL,
            [sprintf("The JSON response does not validate against '%s'.", $schema)] +
            array_map(function (ValidationError $error) {
                return sprintf("[%s] %s", $error->getPointer(), $error->getMessage());
            }, $validator->errors())
        );

        $this->fail($message);
    }
}
