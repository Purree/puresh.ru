<?php

namespace App\Services\Results;

class FunctionResult
{
    public bool $success;
    public mixed $returnValue;
    public string $errorMessage;

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
    public static function error(string $errorMessage): FunctionResult
    {
        $result = new self();
        $result->success = false;
        $result->errorMessage = $errorMessage;
        return $result;
    }
}
