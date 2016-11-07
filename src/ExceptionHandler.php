<?php

namespace Yuloh\JsonGuard\Illuminate;

use Exception;
use Illuminate\Contracts;

/**
 * Decorates the Lumen exception handler to render JSON Schema validation exceptions.
 */
class ExceptionHandler implements Contracts\Debug\ExceptionHandler
{
    /**
     * @var Contracts\Debug\ExceptionHandler
     */
    private $decoratedHandler;

    /**
     * @param Contracts\Debug\ExceptionHandler $decoratedHandler
     */
    public function __construct(Contracts\Debug\ExceptionHandler $decoratedHandler)
    {
        $this->decoratedHandler = $decoratedHandler;
    }

    /**
     * Report or log an exception.
     *
     * @param  \Exception $e
     *
     * @return void
     */
    public function report(Exception $e)
    {
        $this->decoratedHandler->report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Exception               $e
     *
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Exception $e)
    {
        if ($e instanceof JsonSchemaValidationException) {
            return $e->getResponse();
        }

        return $this->decoratedHandler->render($request, $e);
    }

    /**
     * Render an exception to the console.
     *
     * @param  \Symfony\Component\Console\Output\OutputInterface $output
     * @param  \Exception                                        $e
     *
     * @return void
     */
    public function renderForConsole($output, Exception $e)
    {
        $this->decoratedHandler->renderForConsole($output, $e);
    }
}
