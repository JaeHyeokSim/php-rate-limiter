<?php

require "../src/RateLimiter.php";

$limiter = new RateLimiter(3, 10);

$key = "user_1";

for ($i = 1; $i <= 5; $i++) {

	if ($limiter->allow($key)) {

		echo "Request {$i} allowed\n";

	} else {

		echo "Request {$i} blocked\n";

	}

	sleep(1);
}