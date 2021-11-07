<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        private User $user
        ) {}

    /**
    * Create user.
    *
    * @param CreateUserPost $request
    * @return JsonResponse
    */
    public function createUser(Request $request): JsonResponse
    {
        // var_dump($request->all());die();
        $this->success();
        
        $this->response['data'] = $this->user->createUser($request->only('name', 'email', 'password')); 

        return $this->output();
    }
}