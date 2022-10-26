<?php

namespace App\Helpers\Results;

class FunctionResult
{
    public bool $success;

    public mixed $returnValue;

    public string|array $errorMessage;

    /**
        The constructor is private so that methods are only called statically
     */
    private function __construct()
    {
    }

    public static function success($returnValue = null): FunctionResult
    {
        $result = new self();
        $result->success = true;
        $result->returnValue = $returnValue;

        return $result;
    }

    public static function error(string|array $errorMessage): FunctionResult
    {
        $result = new self();
        $result->success = false;
        $result->errorMessage = $errorMessage;

        return $result;
    }
}
