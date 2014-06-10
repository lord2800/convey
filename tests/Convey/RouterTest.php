<?php

use Convey\Router;

class RouterTest extends PHPUnit_Framework_TestCase {
	private $router;

	public function setUp() {
		$this->router = new Router();
	}

	public function testRouterShouldReturnAllRoutesThatMatch() {
		$count = 0;
		$fn = function () use(&$count) { $count++; };
		$this->router->add('get', '/', $fn);
		$this->router->add('get', '/', $fn);

		$route = $this->router->route('get', '/');
		$this->assertSame(2, count($route));
		$this->assertInstanceOf('Closure', $route[0]);
		$this->assertInstanceOf('Closure', $route[1]);
		$route[0]();
		$this->assertSame(1, $count);
		$route[1]();
		$this->assertSame(2, $count);
	}

	public function testFailedRouteShouldReturnEmptyRoute() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->add('get', '/', $fn);
		$route = $this->router->route('get', '/not/the/path');
		$this->assertInstanceOf('Closure', $route[0]);
		$this->assertNotSame($fn, $route[0]);
		$route[0]();
		$this->assertFalse($called);
	}

	public function testAddShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->add('get', '/', $fn);
		$route = $this->router->route('get', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testGetShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->get('/', $fn);
		$route = $this->router->route('get', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testPutShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->put('/', $fn);
		$route = $this->router->route('put', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testPostShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->post('/', $fn);
		$route = $this->router->route('post', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testDeleteShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->delete('/', $fn);
		$route = $this->router->route('delete', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testOptionsShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->options('/', $fn);
		$route = $this->router->route('options', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testHeadShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->head('/', $fn);
		$route = $this->router->route('head', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testPatchShouldPutRouteIntoTheTable() {
		$called = false;
		$fn = function () use(&$called) { $called = true; };
		$this->router->patch('/', $fn);
		$route = $this->router->route('patch', '/');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertTrue($called);
	}

	public function testShouldPassArgumentsThroughToTheHandler() {
		$o = null;
		$t = null;
		$fn = function ($one, $two) use(&$o, &$t) { $o = $one; $t = $two; };
		$this->router->get('/{one}/{two}', $fn);
		$route = $this->router->route('get', '/a/b');
		$this->assertArrayHasKey('0', $route);
		$route[0]();
		$this->assertSame('a', $o);
		$this->assertSame('b', $t);
	}
}
