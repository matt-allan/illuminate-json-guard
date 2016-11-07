<?php

namespace Yuloh\JsonGuard\Illuminate;

use Illuminate\Contracts\Debug\ExceptionHandler as ExceptionHandlerContract;
use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application;
use Laravel\Lumen\Exceptions\Handler;
use League\JsonGuard\Dereferencer;
use Yuloh\JsonGuard\Illuminate\Console\CheckCommand;
use Yuloh\JsonGuard\Illuminate\Console\ValidateCommand;
use Yuloh\JsonGuard\Illuminate\Contracts\Http\ResponseBuilder;
use Yuloh\JsonGuard\Illuminate\Contracts\SchemaLoader as SchemaLoaderContract;
use Yuloh\JsonGuard\Illuminate\Http\JsonSchemaValidationMiddleware;
use Yuloh\JsonGuard\Illuminate\Http\ResponseBuilder\JsonApiResponseBuilder;

class LumenServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->configure('json-guard');
        $this->registerSchemaLoader();
        $this->registerResponseBuilder();
        $this->registerErrorMessageTranslator();
    }

    public function boot()
    {
        $this->loadTranslationsFrom(__DIR__ . '/../resources/lang', 'json-guard');
        $this->registerRouteMiddleware();
        $this->decorateExceptionHandler();
        $this->registerArtisanCommands();
    }

    protected function registerSchemaLoader()
    {
        $this->app->bind(SchemaLoaderContract::class, function (Application $app) {
            $path = $app['config']['json-guard']['schema'];
            $schema = json_decode(file_get_contents($path), false, 512, JSON_BIGINT_AS_STRING);
            return new DefinitionsSchemaLoader($app->make(Dereferencer::class), $schema);
        });
    }

    private function registerResponseBuilder()
    {
        $this->app->bind(ResponseBuilder::class, function (Application $app) {
            return new JsonApiResponseBuilder($app->make(ErrorMessageTranslator::class));
        });
    }

    private function registerErrorMessageTranslator()
    {
        $this->app->bind(ErrorMessageTranslator::class, function (Application $app) {
            return new ErrorMessageTranslator($app->make('translator'));
        });
    }

    private function registerRouteMiddleware()
    {
        $this->app->routeMiddleware([
            'json-schema' => JsonSchemaValidationMiddleware::class
        ]);
    }

    private function decorateExceptionHandler()
    {
        if ($this->app->bound(ExceptionHandlerContract::class)) {
            $handler = $this->app->make(ExceptionHandler::class);
        } else {
            $handler = $this->app->make(Handler::class);
        }

        $this->app->bind(ExceptionHandlerContract::class, function ($app) use ($handler) {
            return new ExceptionHandler($handler);
        });
    }

    private function registerArtisanCommands()
    {
        if ($this->app->runningInConsole()) {
            $this->commands(
                CheckCommand::class,
                ValidateCommand::class
            );
        }
    }
}
