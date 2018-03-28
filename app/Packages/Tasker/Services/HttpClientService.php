<?php namespace Tapklik\Tasker\Services;

use Tapklik\Tasker\Contracts\AbstractService;
use Tapklik\Tasker\Handlers\GuzzleHandler;

class HttpClientService extends AbstractService
{
	public function __construct()
	{
		$this->http = (new GuzzleHandler([
			'base_uri' => env('API_URL'),
			'headers' =>   [
				'Authorization' => 'Bearer ' . env('API_JWT_TOKEN')
			]
		]))->getHandler();
	}

	public function getService()
	{
		return $this->http;
	}
}