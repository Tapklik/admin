<?php namespace Tapklik\Tasker;

use Tapklik\Tasker\Contracts\AbstractRunner;

class Runner extends AbstractRunner
{

	public function execute() {

		$this->recipes->each(function ($recipe) {

			(new $recipe)->handle();
		});
	}
}