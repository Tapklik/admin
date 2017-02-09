<?php

Route::get('/', function () {

    return redirect('/campaigns');
});

Route::get('dashboard', [
	'as'   => 'dashboard.index',
	'uses' => 'DashboardController@index'
]);

Route::get('creatives', [
	'as'   => 'creatives.index',
	'uses' => 'CreativesController@index'
]);

Route::get('users', [
	'as'   => 'users.index',
	'uses' => 'UsersController@index'
]);

Route::get('reports', [
	'as'   => 'reports.index',
	'uses' => 'ReportsController@index'
]);

Route::get('campaigns', [
	'as'   => 'campaigns.index',
	'uses' => 'CampaignsController@index'
]);

Route::get('campaigns/create', [
	'as'   => 'campaigns.create',
	'uses' => 'CampaignsController@create'
]);

Route::get('campaigns/{id}', [
	'as'   => 'campaigns.show',
	'uses' => 'CampaignsController@show'
]);

Route::get('campaigns/{id}/creatives', [
	'as'   => 'campaigns.creatives.show',
	'uses' => 'CampaignsCreativesController@show'
]);

Route::get('accounts', [
	'as'   => 'accounts.index',
	'uses' => 'AccountsController@index'
]);

Route::get('accounts/{id}', [
	'as'   => 'accounts.show',
	'uses' => 'AccountsController@show'
]);

Route::get('accounts/{id}/campaigns', [
	'as'   => 'accounts.campaigns.index',
	'uses' => 'AccountCampaignsController@index'
]);

Route::get('accounts/{id}/campaigns/{cid}', [
	'as'   => 'accounts.campaigns.show',
	'uses' => 'AccountCampaignsController@show'
]);

Route::get('accounts/{id}/creatives', [
	'as'   => 'accounts.noroute',
	'uses' => 'AccountsController@noroute'
]);

Route::get('data/countries', function () {

	$countries = json_decode(file_get_contents('./data/countries.json'), TRUE);

	return response()->json($countries);
});

Route::get('data/countries/{code}', function ($code) {

	try {
	    $country = \App\Country::where(['iso2' => $code])->first();
	    $geographies = \App\Geography::where(['country_id' => $country->id])->get();

	    return response()->json($geographies);
	} catch (Exception $e) {
	    echo $e->getMessage();
		$cities = [];
	}

	return response()->json($cities);
});

Route::get('data/countries/{code}/{id}', function ($code, $id) {

	try {
		$city = \App\City::with(['country'])->findOrFail($id);
	} catch (Exception $e) {
		$city = [];
	}

	return response()->json([
		"country"     => $city->country->code,
		"city"        => $city->name,
		"region"      => $city->region,
		"region_name" => $city->region_name,
	]);
});

Route::get('data/timezones', function () {

	$timezones = json_decode(file_get_contents('./data/timezones.json'), TRUE);

	return response()->json($timezones);
});

Route::get('data/languages', function () {

	$languages = json_decode(file_get_contents('./data/languages.json'), TRUE);

	return response()->json($languages);
});

Route::get('data/categories', function () {

	$categories = json_decode(file_get_contents('./data/categories.json'), TRUE);

	return response()->json($categories);
});

Route::get('test', function () {

	$country = \App\Country::with(['cities'])->find(1);
	dd($country);
});

Route::get('prepare', function () {

	$countries = collect(
		json_decode(
			file_get_contents(
				public_path('data/countries.json')
			)
		)
	)->flatMap(function ($country) {

		return [
			$country->code => [
				'country' => $country->name,
				'code'    => $country->code
			]
		];
	});

	$regions = [];

	$regionsRawData = collect(
		explode("\r\n", file_get_contents(
				public_path('data/regions.csv')
			)
		)
	)->each(function ($region) use (&$regions) {
		$parts = collect(explode(',', $region));
		$parts->offsetUnset($parts->count() - 1);

		if ( !$parts->offsetExists(1)) {
			return;
		}

		if ( !array_key_exists($parts->offsetGet(1), $regions)) {
			$regions[$parts->offsetGet(1)] = [
				'country' => FALSE,
				'cities'  => []
			];
		} else {
			$regions[$parts->offsetGet(1)]['cities'][] = [
				'city'        => $parts->offsetGet(0),
				'region'      => $parts->offsetGet(2),
				'region_name' => $parts->offsetGet(3)
			];
		}
	});

	$prepared = $countries->flatMap(function ($country) use ($regions) {

		$regions = collect($regions);

		return [
			$country['country'] => [
				'country' => $country['country'],
				'code'    => $country['code'],
				'cities'  => $regions->get($country['code'])['cities']
			]
		];
	})->each(function ($country) {

		$newCountry = \App\Country::create([
			'country' => $country['country'],
			'code'    => $country['code']
		]);

		collect($country['cities'])->each(function ($city) use ($newCountry) {

			\App\City::create([
				'country_id'  => $newCountry->id,
				'name'        => $city['city'],
				'region'      => $city['region'],
				'region_name' => $city['region_name'],
			]);
		});
	});
});
