<?php

use Illuminate\Http\Request;
	use Tapklik\Exceptions\TapklikException;

	/*
	|--------------------------------------------------------------------------
	| API Routes
	|--------------------------------------------------------------------------
	|
	| Here is where you can register API routes for your application. These
	| routes are loaded by the RouteServiceProvider within a group which
	| is assigned the "api" middleware group. Enjoy building your API!
	|
	*/

Route::post('/token', function (Request $request) {

    session(['token' => $request->input('token')]);

    return response()->json(['token' => true]);
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
	Route::group(['prefix' => 'tasker'], function () {

		Route::get('/{task}', function ($task) {

			$class = "\\Tapklik\\Tasker\\Recipes\\{$task}";

			if(!class_exists($class))
			{
				return response([
					'error' => true,
					'message' => sprintf('Recipe %s does not exist.', $task)
				]);
			}

			try {
				$tasker = (new $class)->handle();

				return response([
					'status' => 'OK'
				]);
			} catch (TapklikException $e) {
				\Log::error(sprintf('Error %s %s', $e->getMessage(), $e->getCode()));

				return response([
					'error' => true,
					'message' => $e->getMessage()
				]);
			}
		});

	});