<?php

declare(strict_types=1);

require_once './config.php';

if (empty($lang)) {
    $lang = $default_lang;
}
loadlanguage($lang);

$rate = 1 / ($colonist_production_rate > 0 ? $colonist_production_rate : 1);

echo twig()->render('settings.twig', [
    'game_name' => $game_name,
    'release_version' => $release_version,
    'sector_max' => number_format((float)$sector_max),
    'link_max' => $link_max,
    'max_turns' => number_format((float)$max_turns),
    'max_planets_sector' => $max_planets_sector,
    'max_traderoutes_player' => $max_traderoutes_player,
    'fed_max_hull' => $fed_max_hull,
    'min_bases_to_own' => $min_bases_to_own,
    'mine_hullsize' => $mine_hullsize,
    'ewd_maxhullsize' => $ewd_maxhullsize,
    'energy_per_fighter' => $energy_per_fighter,
    'defence_degrade_rate' => ($defence_degrade_rate * 100),
    'basedefense' => $basedefense,
    'allow_ibank' => (bool)$allow_ibank,
    'ibank_interest' => number_format((float)($ibank_interest * 100), 2),
    'ibank_loaninterest' => number_format((float)($ibank_loaninterest * 100), 2),
    'planet_interest_rate' => number_format((float)(($interest_rate - 1) * 100), 2),
    'colonists_per_ore' => number_format((float)($rate / ($ore_prate > 0 ? $ore_prate : 1))),
    'colonists_per_organics' => number_format((float)($rate / ($organics_prate > 0 ? $organics_prate : 1))),
    'colonists_per_goods' => number_format((float)($rate / ($goods_prate > 0 ? $goods_prate : 1))),
    'colonists_per_energy' => number_format((float)($rate / ($energy_prate > 0 ? $energy_prate : 1))),
    'colonists_per_credits' => number_format((float)($rate / ($credits_prate > 0 ? $credits_prate : 1))),
    'colonists_per_fighter' => number_format((float)($rate / ($fighter_prate > 0 ? $fighter_prate : 1))),
    'colonists_per_torpedo' => number_format((float)($rate / ($torpedo_prate > 0 ? $torpedo_prate : 1))),
    'sched_ticks' => $sched_ticks,
    'sched_turns' => $sched_turns,
    'sched_ports' => $sched_ports,
    'sched_planets' => $sched_planets,
    'sched_ranking' => $sched_ranking,
    'sched_degrade' => $sched_degrade,
    'sched_apocalypse' => $sched_apocalypse,
]);
