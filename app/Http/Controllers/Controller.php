<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Log;
use Throwable;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    /**
     * @throws Throwable
     */
    protected function badRequestResponse(Throwable $exception): void
    {
        $trace = debug_backtrace();
        if (isset($trace[1])) {
            $callerFunction = "{$trace[1]['class']}::{$trace[1]['function']}";
            Log::error($callerFunction . ', ' . $exception->getMessage());
        }
        throw $exception;
    }

    protected function handleExceptions(callable $callback)
    {
        try {
            return $callback();
        } catch (Throwable $throwable) {
            $this->badRequestResponse($throwable);
        }
    }
}
