<?php

use Convey\Router;

class RouterTest extends PHPUnit_Framework_TestCase {
	private $router;

	public function setUp() {
		$this->router = new Router();
	}

	public function testRouterShouldReturnAllRoutesThatMatch() {
		$fn = function () {};
		$this->router->add('get', '/', $fn);
		$this->router->add('get', '/', $fn);

		$route = $this->router->route('get', '/');
		$this->assertNotEmpty($route[0][0]);
		$this->assertNotEmpty($route[1][0]);
		$this->assertSame($fn, $route[0][1]);
		$this->assertSame($fn, $route[1][1]);
	}

	public function testFailedRouteShouldReturnEmptyRoute() {
		$fn = function () {};
		$this->router->add('get', '/', $fn);
		$route = $this->router->route('get', '/not/the/path');
		$this->assertEmpty($route[0][0]);
		$this->assertNotSame($fn, $route[0][1]);
	}

	public function testAddShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->add('get', '/', $fn);
		$route = $this->router->route('get', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testGetShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->get('/', $fn);
		$route = $this->router->route('get', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testPutShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->put('/', $fn);
		$route = $this->router->route('put', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testPostShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->post('/', $fn);
		$route = $this->router->route('post', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testDeleteShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->delete('/', $fn);
		$route = $this->router->route('delete', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testOptionsShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->options('/', $fn);
		$route = $this->router->route('options', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testHeadShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->head('/', $fn);
		$route = $this->router->route('head', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}

	public function testPatchShouldPutRouteIntoTheTable() {
		$fn = function () {};
		$this->router->patch('/', $fn);
		$route = $this->router->route('patch', '/');
		$this->assertArrayHasKey('0', $route[0][0]);
		$this->assertSame($fn, $route[0][1]);
	}
}
