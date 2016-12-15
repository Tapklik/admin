<?php

Route::get('accounts', [
	'as' => 'accounts.index',
	'uses' => 'AccountsController@index'
]);

Route::get('accounts/{id}', [
	'as'    => 'accounts.show',
	'uses' => 'AccountsController@show'
]);


Route::get('data/countries', function () {

	$countries = json_decode(file_get_contents('./data/countries.json'), true);

	return response()->json($countries);
});

Route::get('data/timezones', function () {

	$timezones = json_decode(file_get_contents('./data/timezones.json'), true);

	return response()->json($timezones);
});

Route::get('data/languages', function () {

	$languages = json_decode(file_get_contents('./data/languages.json'), true);

	return response()->json($languages);
});