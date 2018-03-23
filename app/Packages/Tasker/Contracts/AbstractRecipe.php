<?php namespace App\Packages\Tasker\Contracts;

use Tapklik\Tasker\Contracts\RecipeInterface;
use Tapklik\Tasker\Handlers\GuzzleHandler;

abstract class AbstractRecipe implements RecipeInterface
{
	protected $client;
	protected $message;

	public function __construct() {

		$config = [
			'base_uri' => 'https://api.tapklik.com',
			'version' => 'v1',
			'headers' => [
				'User-Agent' => 'TKTasker/v1.0.0',
				'Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJub25lIiwianRpIjoiMTIzNDUifQ.eyJpc3MiOiJodHRwczpcL1wvYXBpLnRhcGtsaWsuY29tIiwiYXVkIjoiaHR0cHM6XC9cL2FwaS50YXBrbGlrLmNvbSIsImp0aSI6IjEyMzQ1IiwiaWF0IjoxNTE4MDgwNzY4LCJleHAiOjE1MjA2NzI3NjgsImVtYWlsIjoiaW5mb0B0YXBrbGlrLmNvbSIsImlkIjo1LCJ1dWlkIjoiZDZiYzMwIiwiYWNjb3VudElkIjo2LCJhY2NvdW50VXVJZCI6ImQ2NDM0MyIsIm5hbWUiOiJIYWxpZCBNb3VzYSIsInJvbGUiOiJ1c2VyIiwidHV0b3JpYWwiOjEsImNhbXBhaWducyI6WyIzZjE3YzZjZDhkIiwiYzY3Y2QyZTQ0NiJdfQ.'
			]
		];

		$this->client = (new GuzzleHandler($config))->getHandler();
	}

	protected function setMessage(string $message)
	{
		$this->message = $message;
	}
}