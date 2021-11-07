<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\JsonResponse;

class Controller extends BaseController
{
    use \App\Http\Requests\Outputs;
    
    /**
    * Prepare output.
    *
    * @return Array
    */
    protected function output(): JsonResponse
    {
        return response()->json($this->response);
    }

    /**
    * Throw exception.
    *
    * @return \Exception
    */
    protected function notValidRequest()
    {
        throw new \Exception(json_encode(['data' => ['request' => 'is_not_valid']]), 406);
    }
}
