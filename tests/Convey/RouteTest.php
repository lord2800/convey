<?php

use Convey\Route;

class RouteTest extends PHPUnit_Framework_TestCase {
	public function testSimpleRoute() {
		$route = new Route('/', function () {});
		$this->assertEquals('#^\/$#', $route->regex());
	}

	public function testCatchAllRoute() {
		$route = new Route('*', function () {});
		$this->assertEquals('#^\/.*\/?$#', $route->regex());
	}

	public function testIdentifierRoute() {
		$route = new Route('/:id', function () {});
		$this->assertEquals('#^\/(?P<id>[^\/]+)\/?$#', $route->regex());
	}

	public function testGlobRoute() {
		$route = new Route('/part/*', function () {});
		$this->assertEquals('#^\/part\/.*\/?$#', $route->regex());
	}

	public function testOptionalIdentifierRoute() {
		$route = new Route('/:id?', function () {});
		$this->assertEquals('#^\/(?P<id>[^\/]+)?\/?$#', $route->regex());
	}

	public function testMultipleIdentifierRoute() {
		$route = new Route('/:name/:id', function () {});
		$this->assertEquals('#^\/(?P<name>[^\/]+)\/(?P<id>[^\/]+)\/?$#', $route->regex());
	}

	public function testFailToMatchRoute() {
		$route = new Route('/', function () {});
		$result = $route->match('/will/not/match');
		$this->assertFalse($result);
	}

	public function testMatchSimpleRoute() {
		$route = new Route('/', function () {});
		$result = $route->match('/');
		$this->assertCount(1, $result);
		$this->assertArrayHasKey('0', $result);
		$this->assertEquals('/', $result[0]);
	}

	public function testMatchStaticRoute() {
		$route = new Route('/static/route', function () {});
		$result = $route->match('/static/route');
		$this->assertCount(1, $result);
		$this->assertArrayHasKey('0', $result);
		$this->assertEquals('/static/route', $result[0]);
	}

	public function testMatchIdentifierRoute() {
		$route = new Route('/:id', function () {});
		$result = $route->match('/5');
		$this->assertCount(3, $result);
		$this->assertArrayHasKey('id', $result);
		$this->assertEquals($result['id'], '5');
	}

	public function testMatchMultipleIdentifierRoute() {
		$route = new Route('/:id/:name', function () {});
		$result = $route->match('/5/player');
		$this->assertCount(5, $result);
		$this->assertArrayHasKey('id', $result);
		$this->assertArrayHasKey('name', $result);
		$this->assertEquals($result['id'], '5');
		$this->assertEquals($result['name'], 'player');
	}
}
