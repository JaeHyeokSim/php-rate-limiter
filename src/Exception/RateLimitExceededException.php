<?php

class RateLimitExceededException extends Exception {

	private $retryAfter;

	public function __construct($retryAfter) {

		parent::__construct("Rate limit exceeded");

		$this->retryAfter = $retryAfter;
	}

	public function getRetryAfter() {

		return $this->retryAfter;
	}
}