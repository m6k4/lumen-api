<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Hash;

class User extends Model
{
	public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'email', 
        'password'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password',
    ];

    /**
	* Create user.
	* @param array $params
	* @return User
	*/
	public function createUser(array $params): User
	{
		try{
            return self::create([
				'email' 	=> $params['email'],
				'password' 	=> app('hash')->make($params['password'])
			]);
		} catch (\Throwable $th) {
			\Exceptions::throwDataBaseError($th);
		}
	}

	/**
	* 
	*/
	public function get(): \App\Models\Collection
	{
        try{
		    return self::all();
        } catch (\Throwable $th) {
            var_dump('TEST', $th->getMessage());die();
            \Exceptions::throwDataBaseError($th);
        }
	}
}
