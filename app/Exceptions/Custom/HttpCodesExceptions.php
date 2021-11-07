<?php

namespace App\Exceptions\Custom;

class HttpCodesExceptions
{

    use \App\Http\Requests\Outputs;

     /**
     * Dostępne zwrotki dla wyjątków.
     *
     * @var array
     */
    private array $availables = [
        400 => 'badRequest',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'notFound',
        406 => 'notAcceptable',
        415 => 'unsupportedType',
        500 => 'internalServerError',
        503 => 'serviceUnavailable',
        504 => 'gatewayTimeout'
    ];

        /**
     * Sprawdzenie wyjątku.
     *
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function check($exception)
    {
        $code = $this->getExceptionHTTPStatusCode($exception);
        
        $message = $this->getExceptionHTTPMessage($exception);
        if(json_decode($message, true)) {
            $message = json_decode($message, true)['data'];

            if(!is_null($message)) {
                $message = array_key_exists('customMessages', $message)? $message['customMessages'] : $message;
            }
        }
       
        return array_key_exists($code, $this->availables)? 
            response()->json($this->{$this->availables[$code]}(($code == 406)? $message : 
            ($code == 415 || $code == 503? $message : $code)
            ), $code) : 
            false;
    }

    /**
     * Get code status from exception
     *
     * @return int
     */
    public function getExceptionHTTPStatusCode($exception): int
    {
        return 
            $exception->getCode() > 0? $exception->getCode() :
            (method_exists($exception, 'getStatusCode') ? $exception->getStatusCode() : 500);
    }    

    /**
     * Get message error exception.
     *
     * @return String
     */
    protected function getExceptionHTTPMessage($exception): String
    {
        return method_exists($exception, 'getMessage') ? $exception->getMessage() : '';
    }    
}