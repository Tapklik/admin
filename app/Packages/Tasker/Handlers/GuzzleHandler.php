<?php namespace Tapklik\Tasker\Handlers;

use GuzzleHttp\Client;
use Tapklik\Exceptions\TapklikException;
use Tapklik\Tasker\Contracts\HandlerInterface;

class GuzzleHandler implements HandlerInterface
{
	private $_client = null;

	public function __construct(array $config = []) {

		if(!count($config)) {
			throw new TapklikException('Provide config');
		}

		$this->_client = new Client($config);
	}

	public function getHandler() {

		return $this->_client;
	}
}