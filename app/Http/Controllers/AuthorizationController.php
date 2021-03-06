<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Authorization;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
* AuthorizationController
* Class to manage the endpoints authorization.
*
* @subpackage Controller
*/
class AuthorizationController extends Controller
{

    /**
    * @var ?\stdClass $user
    */
    private $loggedUserSessionDetails = null;

    /**
    * @var ?/files list
    */
    private $filesList = null;

    /**
    * constructor
    *
    * @param private AuthorizationModel $authorizationModel
    * @param private UserModel $userModel
    */
    public function __construct(
        private Authorization $authorization,
        private User $user
        ) {}

    /**
    * login to platform.
    *
    * @param LoginToPlatformPost $request
    * @return JsonResponse
    */
    public function loginToPlatform(Request $request): JsonResponse
    {
        $this->success();

        $sessionToken = Str::random(255);
        $request->session()->put('userSession', $sessionToken);
        $request->session()->save();

        $this->loggedUserSessionDetails = $this->user->where('email', $request->email)->first();
        $this->checkPassword($request->password);

        $this->authorization->createSession($this->loggedUserSessionDetails, $sessionToken);     

        return $this->output();
    }

    /**
    * logout from platform.
    *
    * @param LoginToPlatformPost $request
    * @return JsonResponse
    */
    public function logoutFromPlatform(Request $request): JsonResponse
    {
        $this->success();

        \Session::flush();
        $this->response['data'] = $this->authorization->destroyAllSessions(\SUser::getUserData()->email);
        
        return $this->output();
    }

    /**
    * check if user session exists.
    *
    * @return JsonResponse
    */
    public function checkIfUserSessionExists(Request $request): JsonResponse
    {
        $this->success();

        $sessionToken = $request->session()->get('userSession');
        $this->authorization->checkIfUserSessionExists($sessionToken);
        
        $this->response['data'] = \SUser::getUserData();
        
        return $this->output();
    }

    /**
    * check password
    *
    * @param string $password
    */
    private function checkPassword(string $password) 
    {
        if(!app('hash')->check($password, $this->loggedUserSessionDetails->password)) {
            \Exceptions::throwForbiddenError();
        }
    }
}