<?php

declare(strict_types=1);

namespace BNT\Http;

use Psr\Container\ContainerInterface;

class Router
{
    private array $routes = [];

    public function __construct(private ?ContainerInterface $container = null) {}

    public function get(string $path, callable|string $handler): self
    {
        return $this->add('GET', $path, $handler);
    }

    public function post(string $path, callable|string $handler): self
    {
        return $this->add('POST', $path, $handler);
    }

    public function any(string $path, callable|string $handler): self
    {
        $this->add('GET', $path, $handler);
        $this->add('POST', $path, $handler);
        return $this;
    }

    public function add(string $method, string $path, callable|string $handler): self
    {
        $this->routes[strtoupper($method)][$path] = $handler;
        return $this;
    }

    public function dispatch(Request $request): Response
    {
        $method = $request->method;
        $path = $request->path;

        // Strip trailing slashes unless root
        if ($path !== '/' && str_ends_with($path, '/')) {
            $path = rtrim($path, '/');
        }

        $handler = $this->routes[$method][$path] ?? null;

        if ($handler === null) {
            // Check without .php extension or with .php extension
            if (str_ends_with($path, '.php')) {
                $stripped = substr($path, 0, -4);
                $handler = $this->routes[$method][$stripped] ?? null;
            } else {
                $withPhp = $path . '.php';
                $handler = $this->routes[$method][$withPhp] ?? null;
            }
        }

        if ($handler === null) {
            return Response::html(
                '<h1>404 Not Found</h1><p>The requested star sector or station route does not exist.</p><p><a href="/">Return Home</a></p>',
                404
            );
        }

        if (is_callable($handler)) {
            $result = $handler($request, $this->container);
        } elseif (is_string($handler) && class_exists($handler)) {
            $controller = new $handler($this->container);
            $result = $controller($request);
        } else {
            return Response::html('<h1>500 Internal Server Error</h1>', 500);
        }

        if ($result instanceof Response) {
            return $result;
        }

        if (is_string($result)) {
            return Response::html($result);
        }

        if (is_array($result)) {
            return Response::json($result);
        }

        return Response::html('');
    }
}
