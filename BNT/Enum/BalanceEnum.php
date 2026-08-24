<?php

declare(strict_types=1);

namespace BNT\Enum;

enum BalanceEnum
{

    case ore_price;
    case ore_delta;
    case ore_rate;
    case ore_prate;
    case ore_limit;
    case upgrade_cost;
    case fighter_price;
    case torpedo_price;
    case armor_price;
    case colonist_price;
    case dev_escapepod_price;
    case dev_fuelscoop_price;
    case dev_lssd_price;
    case max_emerwarp;
    case dev_genesis_price;
    case dev_beacon_price;
    case dev_emerwarp_price;
    case dev_warpedit_price;
    case dev_minedeflector_price;
    case goods_price;
    case goods_delta;
    case goods_limit;
    case energy_price;
    case energy_delta;
    case energy_limit;
    case organics_price;
    case organics_delta;
    case organics_limit;
    case inventory_factor;
    case start_armor;
    case start_credits;
    case start_energy;
    case start_fighters;
    case start_turns;
    case start_editors;
    case start_genesis;
    case start_beacon;
    case start_emerwarp;
    case start_minedeflectors;
    case start_lssd;
    case max_turns;
    case sector_max;
    case max_rank;
    case level_factor;
    case base_ore;
    case base_organics;
    case base_goods;
    case base_credits;
    case mine_hullsize;
    case min_bases_to_own;
    case default_lang;
    case torp_dmg_rate;
    case fighter_max;
    case torpedo_max;
    case armor_max;

    public function val(): mixed
    {
        global $level_factor;
        global $ore_price;
        global $ore_delta;
        global $ore_rate;
        global $ore_prate;
        global $ore_limit;
        global $goods_price;
        global $goods_delta;
        global $goods_limit;
        global $energy_price;
        global $energy_delta;
        global $energy_limit;
        global $organics_price;
        global $organics_delta;
        global $organics_limit;
        global $upgrade_cost;
        global $fighter_price;
        global $torpedo_price;
        global $armor_price;
        global $colonist_price;
        global $dev_escapepod_price;
        global $dev_fuelscoop_price;
        global $dev_lssd_price;
        global $max_emerwarp;
        global $dev_genesis_price;
        global $dev_beacon_price;
        global $dev_emerwarp_price;
        global $dev_warpedit_price;
        global $dev_minedeflector_price;
        global $inventory_factor;
        global $start_armor;
        global $start_credits;
        global $start_energy;
        global $start_fighters;
        global $start_turns;
        global $start_editors;
        global $start_genesis;
        global $start_beacon;
        global $start_emerwarp;
        global $start_minedeflectors;
        global $start_lssd;
        global $max_turns;
        global $sector_max;
        global $max_rank;
        global $base_credits;
        global $base_goods;
        global $base_ore;
        global $base_organics;
        global $mine_hullsize;
        global $min_bases_to_own;
        global $default_lang;
        global $torp_dmg_rate;
        global $fighter_max;
        global $torpedo_max;
        global $armor_max;

        return match ($this) {
            BalanceEnum::ore_price => $ore_price ?? 10,
            BalanceEnum::ore_delta => $ore_delta ?? 1,
            BalanceEnum::ore_limit => $ore_limit ?? 5000,
            BalanceEnum::ore_rate => $ore_rate ?? 50,
            BalanceEnum::ore_prate => $ore_prate ?? 50,
            BalanceEnum::upgrade_cost => $upgrade_cost ?? 500,
            BalanceEnum::fighter_price => $fighter_price ?? 5,
            BalanceEnum::torpedo_price => $torpedo_price ?? 10,
            BalanceEnum::armor_price => $armor_price ?? 5,
            BalanceEnum::colonist_price => $colonist_price ?? 2,
            BalanceEnum::dev_escapepod_price => $dev_escapepod_price ?? 1000,
            BalanceEnum::dev_fuelscoop_price => $dev_fuelscoop_price ?? 2500,
            BalanceEnum::dev_lssd_price => $dev_lssd_price ?? 5000,
            BalanceEnum::max_emerwarp => $max_emerwarp ?? 2,
            BalanceEnum::dev_genesis_price => $dev_genesis_price ?? 10000,
            BalanceEnum::dev_beacon_price => $dev_beacon_price ?? 50,
            BalanceEnum::dev_emerwarp_price => $dev_emerwarp_price ?? 1000,
            BalanceEnum::dev_warpedit_price => $dev_warpedit_price ?? 5000,
            BalanceEnum::dev_minedeflector_price => $dev_minedeflector_price ?? 25,
            BalanceEnum::goods_price => $goods_price ?? 20,
            BalanceEnum::goods_delta => $goods_delta ?? 2,
            BalanceEnum::goods_limit => $goods_limit ?? 2500,
            BalanceEnum::energy_price => $energy_price ?? 2,
            BalanceEnum::energy_delta => $energy_delta ?? 1,
            BalanceEnum::energy_limit => $energy_limit ?? 10000,
            BalanceEnum::organics_price => $organics_price ?? 5,
            BalanceEnum::organics_delta => $organics_delta ?? 1,
            BalanceEnum::organics_limit => $organics_limit ?? 10000,
            BalanceEnum::inventory_factor => $inventory_factor ?? 1,
            BalanceEnum::start_armor => $start_armor ?? 100,
            BalanceEnum::start_credits => $start_credits ?? 1000,
            BalanceEnum::start_energy => $start_energy ?? 500,
            BalanceEnum::start_fighters => $start_fighters ?? 10,
            BalanceEnum::start_turns => $start_turns ?? 2500,
            BalanceEnum::start_editors => $start_editors ?? 0,
            BalanceEnum::start_genesis => $start_genesis ?? 0,
            BalanceEnum::start_beacon => $start_beacon ?? 0,
            BalanceEnum::start_emerwarp => $start_emerwarp ?? 0,
            BalanceEnum::start_minedeflectors => $start_minedeflectors ?? 0,
            BalanceEnum::start_lssd => $start_lssd ?? 0,
            BalanceEnum::max_turns => $max_turns ?? 2500,
            BalanceEnum::sector_max => $sector_max ?? 5000,
            BalanceEnum::max_rank => $max_rank ?? 20,
            BalanceEnum::level_factor => $level_factor ?? 1,
            BalanceEnum::base_credits => $base_credits ?? 1000,
            BalanceEnum::base_goods => $base_goods ?? 50,
            BalanceEnum::base_ore => $base_ore ?? 100,
            BalanceEnum::base_organics => $base_organics ?? 100,
            BalanceEnum::mine_hullsize => $mine_hullsize ?? 10,
            BalanceEnum::min_bases_to_own => $min_bases_to_own ?? 1,
            BalanceEnum::default_lang => $default_lang ?? 'english',
            BalanceEnum::torp_dmg_rate => $torp_dmg_rate ?? 10,
            BalanceEnum::fighter_max => $fighter_max ?? 10000,
            BalanceEnum::torpedo_max => $torpedo_max ?? 10000,
            BalanceEnum::armor_max => $armor_max ?? 10000,
        };
    }

}
