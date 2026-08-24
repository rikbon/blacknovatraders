<?php

declare(strict_types=1);

namespace BNT\Http;

class Response
{
    public function __construct(
        public string $content = '',
        public int $statusCode = 200,
        public array $headers = [],
    ) {}

    public static function html(string $content, int $statusCode = 200): self
    {
        return new self($content, $statusCode, ['Content-Type' => 'text/html; charset=UTF-8']);
    }

    public static function json(mixed $data, int $statusCode = 200): self
    {
        return new self(
            (string)json_encode($data, JSON_THROW_ON_ERROR | JSON_UNESCAPED_SLASHES),
            $statusCode,
            ['Content-Type' => 'application/json; charset=UTF-8']
        );
    }

    public static function redirect(string $url, int $statusCode = 302): self
    {
        return new self('', $statusCode, ['Location' => $url]);
    }

    public function send(): void
    {
        http_response_code($this->statusCode);

        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        echo $this->content;
    }
}
