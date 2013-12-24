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
	public function get    ($pathExpr, callable $callback) { self::add('GET', $pathExpr, $callback); }
	public function post   ($pathExpr, callable $callback) { self::add('POST', $pathExpr, $callback); }
	public function put    ($pathExpr, callable $callback) { self::add('PUT', $pathExpr, $callback); }
	public function patch  ($pathExpr, callable $callback) { self::add('PATCH', $pathExpr, $callback); }
	public function delete ($pathExpr, callable $callback) { self::add('DELETE', $pathExpr, $callback); }
	public function options($pathExpr, callable $callback) { self::add('OPTIONS', $pathExpr, $callback); }
	public function head   ($pathExpr, callable $callback) { self::add('HEAD', $pathExpr, $callback); }

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
