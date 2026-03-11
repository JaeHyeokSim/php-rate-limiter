<?php

class RateLimiter {

	private $limit;
	private $window;
	private $storage = [];

	public function __construct($limit, $windowSeconds) {

		$this->limit = $limit;
		$this->window = $windowSeconds;
	}

	public function allow($key) {

		$now = time();

		if (!isset($this->storage[$key])) {
			$this->storage[$key] = [];
		}

		// 오래된 요청 제거
		$this->storage[$key] = array_filter(
			$this->storage[$key],
			function ($timestamp) use ($now) {
				return $timestamp > ($now - $this->window);
			}
		);

		if (count($this->storage[$key]) >= $this->limit) {
			return false;
		}

		$this->storage[$key][] = $now;

		return true;
	}

	public function getRemaining($key) {

		if (!isset($this->storage[$key])) {
			return $this->limit;
		}

		return $this->limit - count($this->storage[$key]);
	}

	public function reset($key) {

		unset($this->storage[$key]);
	}
}