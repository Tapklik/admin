<?php

class TaskerRunnerTest extends TestCase
{

	/** @test */
	public function it_loads_recipes()
	{
		$runner = new \Tapklik\Tasker\Runner();
		$runner->execute();
	}
}