<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use App\Models\{User};
use Illuminate\Support\Str;

class Authorization extends Model
{
	public $timestamps = false;

	protected $table = 'sessions';

	protected $hidden = ['password', 'token', 'fk_user_id'];

	protected $fillable = [
		'token',
		'expired_at',
		'fk_user_id',
	];

	
	protected $with = [
		'users',
	];

	/**
	 * Login to platform.
	 */
	public function createSession(User $userDetails, string $sessionToken)
	{
		try {
			
			\DB::beginTransaction();
			$this->destroyAllSessions($userDetails->id);

			self::create([
				'fk_user_id' 				=> $userDetails->id,
				'expired_at'  				=> Carbon::now()->addHours(3),
				'token'						=> $sessionToken
			]);

			\DB::commit();
		} catch (\Throwable $th) {
			var_dump($th->getMessage());die();
			\DB::rollback();
			\Exceptions::throwDataBaseError($th);
		}
	}

	/**
	 * Check if user session exists
	 * @return  Authorization
	 */
	public function checkIfUserSessionExists(string $sessionToken): Authorization
	{
		try {
			$userSession = self::select()
				->where('token', $sessionToken)
				->where('expired_at', '>', Carbon::now())
				->get()
				->first();
		} catch (\Throwable $th) {
			\Exceptions::throwDataBaseError($th);
		}

		if (!$userSession)
			\Exceptions::throwForbiddenError();

		\SUser::setUserData($userSession);

		return $userSession;
	}

	/**
	 * Destroy all user sessions
	 */
	public function destroyAllSessions(int $userId)
	{
		self::where('fk_user_id', $userId)
			->delete();
	}

	/**
	 * @return HasOne
	 */
	public function users(): HasOne
	{
		return $this->hasOne(
			(new User),
			'id',
			'fk_user_id'
		);
	}
}
