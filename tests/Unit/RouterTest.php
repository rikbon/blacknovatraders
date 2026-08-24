<?php

declare(strict_types=1);

namespace BNT\Test\Unit;

use PHPUnit\Framework\TestCase;
use BNT\Http\Router;
use BNT\Http\Request;
use BNT\Http\Response;

final class RouterTest extends TestCase
{
    public function testRouterDispatchesMatchingGetRoute(): void
    {
        $router = new Router();
        $router->get('/status', function (Request $request) {
            return Response::json(['status' => 'online', 'system' => 'alpha_centauri']);
        });

        $request = new Request(
            method: 'GET',
            uri: '/status',
            path: '/status',
            query: [],
            body: [],
            cookies: [],
            server: [],
        );

        $response = $router->dispatch($request);

        $this->assertSame(200, $response->statusCode);
        $this->assertSame('application/json; charset=UTF-8', $response->headers['Content-Type']);
        $this->assertStringContainsString('alpha_centauri', $response->content);
    }

    public function testRouterMatchesLegacyPhpExtension(): void
    {
        $router = new Router();
        $router->get('/rankings', function () {
            return Response::html('<h1>Rankings</h1>');
        });

        $request = new Request(
            method: 'GET',
            uri: '/rankings.php',
            path: '/rankings.php',
            query: [],
            body: [],
            cookies: [],
            server: [],
        );

        $response = $router->dispatch($request);
        $this->assertSame(200, $response->statusCode);
        $this->assertStringContainsString('<h1>Rankings</h1>', $response->content);
    }

    public function testRouterReturns404ForUnknownRoutes(): void
    {
        $router = new Router();
        $request = new Request(
            method: 'GET',
            uri: '/non-existent-sector',
            path: '/non-existent-sector',
            query: [],
            body: [],
            cookies: [],
            server: [],
        );

        $response = $router->dispatch($request);
        $this->assertSame(404, $response->statusCode);
    }
}
