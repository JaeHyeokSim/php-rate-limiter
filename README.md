# PHP Rate Limiter

Simple sliding window rate limiter written in PHP.

## Features

- Sliding window algorithm
- Storage abstraction
- Retry-after support
- Remaining quota tracking

## Example

```php
$limiter = new RateLimiter(3, 10);

try {
	$limiter->allow("user1");
} catch (RateLimitExceededException $e) {
	echo "Retry after " . $e->getRetryAfter();
}
```

## Rate limit headers

```
X-RateLimit-Limit
X-RateLimit-Remaining
Retry-After
```