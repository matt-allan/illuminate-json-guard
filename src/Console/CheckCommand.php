<?php

namespace Yuloh\JsonGuard\Illuminate\Console;

use Illuminate\Console\Command;
use Yuloh\JsonGuardCli\Commands\Check;

class CheckCommand extends Command
{
    protected $signature = 'json-schema:check {schema : The schema to check}';

    protected $description = 'Check that a JSON Schema is valid';

    public function handle()
    {
        (new Check())->__invoke($this->argument('schema'), $this->getOutput());
    }
}
