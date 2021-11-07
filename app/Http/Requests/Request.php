<?php

namespace App\Http\Requests;

use App\Http\Requests\Outputs;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

abstract class Request extends FormRequest
{
    use \App\Http\Requests\Outputs;

    
    public function failedValidation(Validator $validator)
    {
        abort(\Illuminate\Http\Response::HTTP_NOT_ACCEPTABLE, json_encode($this->notAcceptable($validator->getMessageBag()->getMessages())));
    }
    
    public function all($keys = NULL)
    {
        return array_intersect_key(\Request::all(), array_flip($this->allowed));
    }

}