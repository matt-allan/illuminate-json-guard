<?php

namespace Yuloh\JsonGuard\Illuminate\Console;

use Illuminate\Console\Command;
use Yuloh\JsonGuardCli\Commands\Validate;

class ValidateCommand extends Command
{
    protected $signature = 'json-schema:validate {data : The data to validate} {schema : The schema to validate against}';

    protected $description = 'Validate JSON data against a schema';

    public function handle()
    {
        return (new Validate())->__invoke($this->argument('data'), $this->argument('schema'), $this->getOutput());
    }
}
