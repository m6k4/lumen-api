<?php

namespace App\Services;

use App\Models\Authorization;

class UserData 
{  
    private static ?Authorization $userData = null;

    /**
     * Get user data.
     * @return Authorization
    */
    public static function getUserData(): Authorization
    {
        if(!self::$userData) {
          \Exceptions::throwForbiddenError();
        }
        
        return self::$userData;
    } 

    /**
    * Set user data.
    * @param Authorization $userParams.
    */
    public static function setUserData(Authorization $userParams): void
    {
        if(!self::$userData)
          self::$userData = $userParams;
    }
}