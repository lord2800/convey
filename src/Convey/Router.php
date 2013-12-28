<?php
namespace Convey;

class Router {
	private $table = [
		'GET' => [],
		'POST' => [],
		'PUT' => [],
		'PATCH' => [],
		'DELETE' => [],
		'OPTIONS' => [],
		'HEAD' => []
	];

	public function add($method, $pathExpr, callable $callback) { $this->table[strtoupper($method)][] = new Route($pathExpr, $callback); }

	// aliases for common methods
	public function get    ($pathExpr, callable $callback) { self::add('GET', $pathExpr, $callback); }
	public function post   ($pathExpr, callable $callback) { self::add('POST', $pathExpr, $callback); }
	public function put    ($pathExpr, callable $callback) { self::add('PUT', $pathExpr, $callback); }
	public function patch  ($pathExpr, callable $callback) { self::add('PATCH', $pathExpr, $callback); }
	public function delete ($pathExpr, callable $callback) { self::add('DELETE', $pathExpr, $callback); }
	public function options($pathExpr, callable $callback) { self::add('OPTIONS', $pathExpr, $callback); }
	public function head   ($pathExpr, callable $callback) { self::add('HEAD', $pathExpr, $callback); }

	public function route($method, $path) {
		$results = [];
		foreach($this->table[strtoupper($method)] as $route) {
			$args = $route->match($path);
			if(is_array($args)) {
				$results[] = [$args, $route->callback];
			}
		}
		// default is a no-op route
		if(empty($results)) {
			return [[[], function () {}]];
		} else {
			return $results;
		}
	}
}
