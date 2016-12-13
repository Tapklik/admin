<?php

Route::get('accounts', [
	'as' => 'accounts.index',
	'uses' => 'AccountsController@index'
]);

Route::get('accounts/{id}', [
	'as'    => 'accounts.show',
	'uses' => 'AccountsController@show'
]);

Route::get('/', function () {

	return view('design');
});
