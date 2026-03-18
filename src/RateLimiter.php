<?php

require_once __DIR__ . '/Storage/MemoryStorage.php';
require_once __DIR__ . '/Exception/RateLimitExceededException.php';

class RateLimiter
{

    private $limit;
    private $window;
    private $storage;

    public function __construct($limit = 5, $windowSeconds = 1, $storage = null)
    {

        $this->limit = $limit;
        $this->window = $windowSeconds;
        $this->storage = $storage ?: new MemoryStorage();
    }

    public function allow($key)
    {

        $now = time();

        $requests = $this->storage->get($key);

        if (!$requests) {
            $requests = [];
        }

        $requests = array_filter(
            $requests,
            function ($timestamp) use ($now) {
                return $timestamp > ($now - $this->window);
            }
        );

        if (count($requests) >= $this->limit) {

            $retryAfter = min($requests) + $this->window - $now;

            throw new RateLimitExceededException($retryAfter);
        }

        $requests[] = $now;

        $this->storage->set($key, $requests);

        return true;
    }

    public function getRemaining($key)
    {

        $requests = $this->storage->get($key);

        if (!$requests) {
            return $this->limit;
        }

        return $this->limit - count($requests);
    }

    public function getRetryAfter($key)
    {

        $requests = $this->storage->get($key);

        if (!$requests) {
            return 0;
        }

        $oldest = min($requests);

        return ($oldest + $this->window) - time();
    }

    public function getLimit()
    {
        return $this->limit;
    }

    public function getWindow()
    {
        return $this->window;
    }
}
