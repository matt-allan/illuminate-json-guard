<?php

namespace Yuloh\JsonGuard\Illuminate;

use League\JsonGuard\Dereferencer;
use League\JsonGuard\Pointer;
use Yuloh\JsonGuard\Illuminate\Contracts\SchemaLoader;

class DefinitionsSchemaLoader implements SchemaLoader
{
    /**
     * @var Dereferencer
     */
    private $dereferencer;

    /**
     * @var object
     */
    private $schema;

    /**
     * @param Dereferencer $dereferencer
     * @param object       $schema
     */
    public function __construct(Dereferencer $dereferencer, $schema)
    {
        $this->dereferencer = $dereferencer;
        $this->schema       = $this->dereferencer->dereference($schema);
    }

    /**
     * Load the given schema.
     *
     * @param string $schema
     *
     * @return object
     */
    public function __invoke(string $schema)
    {
        return (new Pointer($this->schema))->get(ltrim($schema, '#'));
    }
}
