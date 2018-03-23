<?php namespace Tapklik\Tasker\Contracts;

abstract class AbstractRunner
{
	const RECIPE_DIR = __DIR__ . '/../Recipes';

	protected $recipes = [];

	public function __construct()
	{
		$this->recipes = $this->_loadRecipes();
	}

	private function _loadRecipes()
	{

		return collect(scandir(self::RECIPE_DIR))->map(function ($recipe) {

			if (is_file(self::RECIPE_DIR . '/' . $recipe)) {
				$className = str_replace('.php', '', $recipe);

				return "\\Tapklik\\Tasker\\Recipes\\{$className}";
			}
		})->filter(function ($class) {

			return class_exists($class);
		})->flatten();
	}
}