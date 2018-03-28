<?php namespace App\Packages\Tasker\Contracts;

use Tapklik\Tasker\Contracts\RecipeInterface;
use Tapklik\Tasker\Services\CourierService;
use Tapklik\Tasker\Services\HttpClientService;

abstract class AbstractRecipe implements RecipeInterface
{
	protected $http;
	protected $courier;
	protected $message;

	public function __construct()
	{
		$this->http = (new HttpClientService())->getService(); // Provide HTTP functionality to all recipes
		$this->courier = (new CourierService())->getService(); // Provide notification functionality to all recipes

		$this->boot(); // Boot class if we need any additional processing prior to execution
	}

	protected function setMessage(string $message)
	{
		$this->message = $message;
	}

	abstract function boot();

}