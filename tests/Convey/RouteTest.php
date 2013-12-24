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
}
