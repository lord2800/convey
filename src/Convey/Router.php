<?php
namespace Convey;

class Router {
	private $table = [];

	public function add($method, $pathExpr, callable $callback) {
		$method = strtoupper($method);
		if(!key_exists($method, $this->table)) {
			$this->table[$method] = [];
		}
		$this->table[$method][] = new Route($pathExpr, $callback);
	}

	// aliases for common methods
	public function get($pathExpr, callback $callback) { self::add('GET', $pathExpr, $callback); }
	public function post($pathExpr, callback $callback) { self::add('POST', $pathExpr, $callback); }
	public function put($pathExpr, callback $callback) { self::add('PUT', $pathExpr, $callback); }
	public function patch($pathExpr, callback $callback) { self::add('PATCH', $pathExpr, $callback); }
	public function delete($pathExpr, callback $callback) { self::add('DELETE', $pathExpr, $callback); }
	public function options($pathExpr, callback $callback) { self::add('OPTIONS', $pathExpr, $callback); }
	public function head($pathExpr, callback $callback) { self::add('HEAD', $pathExpr, $callback); }

	public function route($method, $path) {
		foreach($this->table[$method] as $route) {
			$args = $route->match($path);
			if(!$args && is_array($args)) {
				return [$args, $route->callback];
			}
		}
		// default is a no-op route
		return [[], function () {}];
	}
}
