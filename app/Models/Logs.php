<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Logs extends Model
{
	static private $tableName = 'logs';

	/**
	* Create log.
	* @param array $params
	*/
	public function createLog(array $params): void
	{
		try{
			$params['message'] = is_array($params['message'])? json_encode($params['message']) : $params['message'];
			$this->query = \DB::table(self::$tableName)
			->insert($params);
			
		} catch (\Throwable $e) {
			\Exceptions::throwDataBaseError($e);
		}
	}

	/**
	 * Save log to db by exception.
	 *
	 * @param  \Exception  $exception
	 */
	public function createLogFromException($exception): void
	{
			if(!strstr($exception->getFile(), 'CustomExceptions.php')) {
				
					$params = [
							'message'   => $exception->getMessage(),
							'exception' => 'Exception',
							'file'      => $exception->getFile(),
							'line'      => $exception->getLine(),
					];
					$this->createLog($params);
			}
	}

	/**
	 * Save log to db by response.
	 *
	 * @param  String  $content
	 */
	public function createLogFromResponse(String $content): void
	{
	
			$content = json_decode($content);

			if(!strstr($content->file, 'CustomExceptions.php')) {
					$this->createLog(\Arr::only((array)$content, ['message', 'exception', 'file', 'line']));
			}
	}
}