<?php

require_once "../src/RateLimiter.php";

$limiter = new RateLimiter(3, 10);

$key = "user_1";

for ($i = 1; $i <= 5; $i++) {

	try {

		$limiter->allow($key);

		echo "Request {$i} allowed\n";

	} catch (RateLimitExceededException $e) {

		echo "Blocked. Retry after: " . $e->getRetryAfter() . " seconds\n";
	}

	sleep(1);
}