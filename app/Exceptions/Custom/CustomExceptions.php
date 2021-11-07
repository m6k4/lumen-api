<?php

namespace App\Exceptions\Custom;

class CustomExceptions
{
    /**
     * Throw database exception.
     */
    static public function throwDataBaseError(\Throwable $exception): void
    {
        (new \App\Models\Logs())->createLogFromException($exception);
        throw new \Exception(json_encode(['data' => ['database' => 'Błąd składni SQL']]), 406);
    }

    /**
     * Throw forbidden exception.
     */
    static public function throwForbiddenError(): void
    {
        throw new \Exception(json_encode(['data' => ['request' => 'forbidden']]), 403);
    }

    static public function throwEnvironmentError(String $environment): void
    {
        throw new \Exception(json_encode(['data' => ['environment' => "The environment is not set or environment '" . $environment . "' is turned off."]]), 503);
    }

    static public function throwError(array $data, $code = 406): void
    {
        throw new \Exception(json_encode(['data' => $data]), $code);
    }
}
