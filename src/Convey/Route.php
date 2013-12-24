<?php
namespace Convey;

class Route {
	public $callback = null;
	private $path;

	public function __construct($pathExpr, callable $callback) {
		$this->callback = $callback;
		// transform rules:
		// :identifier is a regex that matches to the next /
		// ? is an optional modifier
		// * means match the rest of the url implicitly

		// OPTIMIZATION: if the path expression is a /, then set a hardcoded
		// regex
		if($pathExpr === '/') {
			$this->path = '#^\/$#';
			return;
		}

		$parts = explode('/', $pathExpr);
		$pathExpr = '';

		foreach($parts as $part) {
			if(empty($part)) {
				continue;
			}

			$pathExpr .= '\/';

			$optional = false;
			if(strlen($part) > 1 && $part[strlen($part)-1] === '?') {
				$optional = true;
				$part = substr($part, 0, -1);
			}

			if($part[0] === ':') {
				$pathExpr .= '(?P<' . substr($part, 1) . '>[^\/]+)';
			} else if($part[0] === '*') {
				$pathExpr .= '.*';
				break;
			} else {
				$pathExpr .= preg_quote($part);
			}

			if($optional) {
				$pathExpr .= '?';
			}
		}
		// optionally match a trailing /
		$pathExpr .= '\/?';
		$this->path = '#^' . $pathExpr . '$#';
	}

	public function regex() { return $this->path; }

	public function match($path) {
		if(preg_match($this->path, $path) === 1) {
			return $matches;
		}
		return false;
	}
}
