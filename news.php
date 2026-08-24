<?php

declare(strict_types=1);

use BNT\News\DAO\NewsRetrieveManyByCriteriaDAO;

require_once './config.php';

if (empty($lang)) {
    $lang = $default_lang;
}
loadlanguage($lang);

connectdb();

$dateParam = $_GET['startdate'] ?? null;

try {
    $startdate = $dateParam ? new \DateTimeImmutable($dateParam) : new \DateTimeImmutable('today');
} catch (\Throwable $e) {
    $startdate = new \DateTimeImmutable('today');
}

$previousday = $startdate->sub(new \DateInterval('P1D'));
$nextday = $startdate->add(new \DateInterval('P1D'));

$retrieveNews = NewsRetrieveManyByCriteriaDAO::new($container);
$retrieveNews->dateFrom = $startdate->setTime(0, 0, 0);
$retrieveNews->dateTo = $startdate->setTime(23, 59, 59);
$retrieveNews->sortByNewsIdDESC = true;
$retrieveNews->serve();

echo twig()->render('news.twig', [
    'news' => $retrieveNews->news,
    'startdate' => $startdate,
    'nextday' => $nextday,
    'previousday' => $previousday,
]);
