<?php


namespace App\Http\Requests;

trait Outputs
{   
    protected $response = [
        'data'      =>  [],
        'code'      =>  200,
        'message'   =>  'success'
    ];
   
    protected function gatewayTimeout($errors = [])
    {
        $this->response['code'] = 520;
        $this->response['message'] = 'gateway_timeout';
        return $this->response;
    }   
  
    protected function notAcceptable($errors = [])
    {
        $this->response['code'] = 406;
        $this->response['data'] = $errors;
        $this->response['message'] = 'not_acceptable';

        return $this->response;
    }

    protected function unsupportedType($message = '')
    {
        $this->response['code'] = 415;
        $this->response['data'] = $message;
        $this->response['message'] = 'unsupported_type';

        return $this->response;
    }

    protected function serviceUnavailable($message = '')
    {
        $this->response['code'] = 503;
        $this->response['data'] = $message;
        $this->response['message'] = 'service_unavailable';
        return $this->response;
    }   

    protected function forbidden($code = 403)
    {
        $this->response['code'] = 403;
        $this->response['message'] = 'forbidden';
        return $this->response;
    }    

    protected function unauthorized($code = 401)
    {
        $this->response['code'] = 401;
        $this->response['message'] = 'unauthorized';

        return $this->response;
    }    

    protected function tooManyRequest($code = 429)
    {
        $this->response['code'] = 429;
        $this->response['message'] = 'to_many_requests';
        return $this->response;
    }   

    protected function notImplemented($code = 501)
    {
        $this->response['code'] = 501;
        $this->response['message'] = 'not_implemented';
        return $this->response;
    } 

    protected function success($data = [], $code = 200)
    {
        $this->response['code'] = 200;
        $this->response['message'] = 'success';
        $this->response['data'] = $data ?? [];
        return $this->response;
    }    

    protected function notFound($code = 404)
    {
        $this->response['code'] = 404;    
        $this->response['message'] = 'not_found';
        return $this->response;
    }    

    protected function badRequest($code = 400)
    {
        $this->response['code'] = 400;
        $this->response['message'] = 'bad_request';

        return $this->response;
    }   

    protected function internalServerError($code = 500)
    {
        $this->response['code'] = $code;
        $this->response['message'] = 'internal_server_error';

        return $this->response;
    }      
}