<?php
namespace Convey;

use Rize\UriTemplate;

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
	protected $emptyRoute;
	public function __construct() { $this->emptyRoute = \Closure::bind(function () {}, null); }

	public function add($method, $path, callable $cb) {
		$this->table[strtoupper($method)][] = [$path, $cb];
	}

	// aliases for common methods
	public function get    ($path, callable $cb) { self::add('GET',     $path, $cb); }
	public function post   ($path, callable $cb) { self::add('POST',    $path, $cb); }
	public function put    ($path, callable $cb) { self::add('PUT',     $path, $cb); }
	public function patch  ($path, callable $cb) { self::add('PATCH',   $path, $cb); }
	public function delete ($path, callable $cb) { self::add('DELETE',  $path, $cb); }
	public function options($path, callable $cb) { self::add('OPTIONS', $path, $cb); }
	public function head   ($path, callable $cb) { self::add('HEAD',    $path, $cb); }

	public function route($method, $path) {
		$parser = new UriTemplate();
		$results = [];

		$routes = $this->table[strtoupper($method)];
		foreach($routes as $route) {
			$args = $parser->extract($route[0], $path, true);
			if(isset($args)) {
				// reflect this function as late as possible, since *most* routes shouldn't be called
				$ref = new \ReflectionFunction($route[1]);
				$results[] = \Closure::bind(function () use($ref, $args) { return $ref->invokeArgs($args); }, null);
			}
		}

		// always return a callable function inside an array
		return empty($results) ? [$this->emptyRoute] : $results;
	}
}
