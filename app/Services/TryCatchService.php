<?php

namespace App\Services;

use App\Traits\ResponseTrait;
use Exception;

class TryCatchService
{
    use ResponseTrait;

    public static function execute($function, $onError)
    {
        try {
            return $function();
        } catch (Exception $e) {
            $onError();

            return ResponseTrait::Error("Error at file: {$e->getFile()} at line: {$e->getLine()} error: {$e->getMessage()}", 500);
        }
    }
}
