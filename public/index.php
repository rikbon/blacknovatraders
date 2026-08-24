<?php

declare(strict_types=1);

// Set working directory to project root for seamless file includes
chdir(dirname(__DIR__));

// Initialize configuration, session, and DI container
require_once 'config.php';

use BNT\Http\Request;
use BNT\Http\Response;
use BNT\Http\Router;

$request = Request::capture();
$router = new Router($container);

// Define Application Routes
$router->get('/', function () {
    return Response::html(twig()->render('index.twig', ['title' => 'Home']));
});

$router->get('/index.php', function () {
    return Response::html(twig()->render('index.twig', ['title' => 'Home']));
});

$router->get('/login', function () {
    return Response::html(twig()->render('login/login.twig'));
});

$router->get('/login.php', function () {
    return Response::html(twig()->render('login/login.twig'));
});

$router->post('/login2.php', function (Request $req, $container) {
    // Process login via ShipLoginServant
    $servant = \BNT\Ship\Servant\ShipLoginServant::new($container);
    $servant->ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    $servant->email = $req->body['email'] ?? '';
    $servant->password = $req->body['pass'] ?? '';

    try {
        $servant->serve();
        $_SESSION['username'] = $servant->email;
        $_SESSION['ship_id'] = $servant->ship->ship_id;
        return Response::redirect('/main.php');
    } catch (\Throwable $e) {
        return Response::html(
            '<div style="max-width: 500px; margin: 40px auto; color: #f87171; text-align: center; font-family: sans-serif;">' .
            '<h2>Authentication Failed</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>' .
            '<p><a href="/login.php" style="color: #38bdf8;">Return to Login</a></p></div>',
            401
        );
    }
});

$router->get('/new.php', function () {
    return Response::html(twig()->render('new/new.twig'));
});

$router->post('/new2.php', function (Request $req, $container) {
    $servant = \BNT\Ship\Servant\ShipNewServant::new($container);
    $servant->username = $req->body['username'] ?? '';
    $servant->character = $req->body['character'] ?? '';
    $servant->shipname = $req->body['shipname'] ?? '';
    $servant->password = $req->body['password'] ?? '';
    $servant->ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

    try {
        $servant->serve();
        return Response::html(twig()->render('new/new2.twig', ['username' => $servant->username]));
    } catch (\Throwable $e) {
        return Response::html(
            '<div style="max-width: 500px; margin: 40px auto; color: #f87171; text-align: center; font-family: sans-serif;">' .
            '<h2>Registration Error</h2><p>' . htmlspecialchars($e->getMessage()) . '</p>' .
            '<p><a href="/new.php" style="color: #38bdf8;">Return to Registration</a></p></div>',
            400
        );
    }
});

$router->get('/ranking.php', function () {
    require_once dirname(__DIR__) . '/ranking.php';
    return Response::html('');
});

$router->get('/settings.php', function () {
    require_once dirname(__DIR__) . '/settings.php';
    return Response::html('');
});

$router->get('/news.php', function () {
    require_once dirname(__DIR__) . '/news.php';
    return Response::html('');
});

$router->get('/help.php', function () {
    require_once dirname(__DIR__) . '/help.php';
    return Response::html('');
});

$router->get('/faq.php', function () {
    require_once dirname(__DIR__) . '/faq.php';
    return Response::html('');
});

$router->get('/faq.html', function () {
    return Response::redirect('/faq.php');
});

// Fallback for legacy scripts during migration
$path = $request->path;
$scriptPath = dirname(__DIR__) . '/' . ltrim($path, '/');
if (file_exists($scriptPath) && is_file($scriptPath) && str_ends_with($scriptPath, '.php')) {
    ob_start();
    require $scriptPath;
    $output = ob_get_clean();
    $response = Response::html($output ?: '');
} else {
    $response = $router->dispatch($request);
}

$response->send();
