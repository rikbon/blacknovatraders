<?php

declare(strict_types=1);

namespace BNT\Http;

class Request
{
    public function __construct(
        public readonly string $method,
        public readonly string $uri,
        public readonly string $path,
        public readonly array $query,
        public readonly array $body,
        public readonly array $cookies,
        public readonly array $server,
    ) {}

    public static function capture(): self
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '/';
        $path = parse_url($uri, PHP_URL_PATH) ?: '/';
        $method = strtoupper($_SERVER['REQUEST_METHOD'] ?? 'GET');

        return new self(
            method: $method,
            uri: $uri,
            path: $path,
            query: $_GET,
            body: $_POST,
            cookies: $_COOKIE,
            server: $_SERVER,
        );
    }
}
