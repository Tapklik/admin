<?php

Route::get('campaigns', [
	'as' => 'campaigns.index',
	'uses' => 'CampaignsController@index'
]);

Route::get('campaigns/{id}/creatives', [
	'as' => 'campaigns.creatives.show',
	'uses' => 'CampaignsCreativesController@show'
]);

Route::get('accounts', [
	'as' => 'accounts.index',
	'uses' => 'AccountsController@index'
]);

Route::get('accounts/{id}', [
	'as'    => 'accounts.show',
	'uses' => 'AccountsController@show'
]);

Route::get('accounts/{id}/campaigns', [
	'as'    => 'accounts.campaigns.index',
	'uses' => 'AccountCampaignsController@index'
]);

Route::get('accounts/{id}/creatives', [
	'as'    => 'accounts.noroute',
	'uses' => 'AccountsController@noroute'
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