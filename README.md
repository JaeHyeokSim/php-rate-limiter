# PHP Rate Limiter

Simple rate limiter implementation in PHP.

## Features

- request limiting
- sliding window
- per key limit
- remaining quota check

## Example

```php
$limiter = new RateLimiter(3, 10);

if ($limiter->allow("user1")) {
	echo "allowed";
}