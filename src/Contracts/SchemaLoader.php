<?php

namespace Yuloh\JsonGuard\Illuminate\Contracts;

interface SchemaLoader
{
    /**
     * Load the given schema.
     *
     * @param string $schema
     *
     * @return object
     */
    public function __invoke(string $schema);
}
