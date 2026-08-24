<?php

declare(strict_types=1);

require_once './config.php';

if (empty($lang)) {
    $lang = $default_lang;
}
loadlanguage($lang);

echo twig()->render('help/help.twig', [
    'allow_navcomp' => $allow_navcomp ?? true,
    'allow_fullscan' => $allow_fullscan ?? true,
]);
