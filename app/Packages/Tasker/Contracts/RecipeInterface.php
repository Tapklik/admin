<?php namespace Tapklik\Tasker\Contracts;


interface RecipeInterface
{
	public function boot();

	public function handle();
}