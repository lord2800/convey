<?php

use Convey\Router;

class RouterTest extends PHPUnit_Framework_TestCase {
	private $router;

	public function setUp() {
		$this->router = new Router();
	}

	public function testAddShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->add('get', '/', $fn);
		$route = $this->router->route('get', '/');
		$this->assertEmpty($route[0]);
		// assertSame fails for some strange reason
		$this->assertEquals($fn, $route[1]);
	}
}
