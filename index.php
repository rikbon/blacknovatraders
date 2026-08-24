<?php

declare(strict_types=1);

require_once './config.php';

if (empty($lang)) {
    $lang = $default_lang;
}
loadlanguage($lang);

echo twig()->render('index.twig', [
    'title' => 'Home',
]);
