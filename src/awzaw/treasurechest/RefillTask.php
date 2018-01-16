<?php

namespace awzaw\treasurechest;

use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\tile\Chest;
use pocketmine\level\Level;

class RefillTask extends PluginTask {

    public function onRun(int $tick) {

        foreach ($this->getOwner()->config->getAll() as $c => $chestmode) {
            $c = explode(":", $c);
            if (!(($lev = $this->getOwner()->getServer()->getLevelByName($c[3])) instanceof Level))
                continue;
            $tile = $lev->getTile(new Vector3((int) $c[0], (int) $c[1], (int) $c[2]));
            if (!$tile)
                continue;
            if (!($tile instanceof Chest))
                continue;

            $tile->getInventory()->clearAll();
            $inv = $tile->getInventory();

            foreach ($this->getOwner()->treasure->getAll() as $treasure => $tarray) {

                if ($treasure === $chestmode) {
                    $i = 0;
                    foreach ($tarray as $tstring) {
                        $t = explode(":", $tstring);
                        
                        $amount = $t[1];
                        if ($this->getOwner()->prefs->get("RandomizeAmount"))
                            $amount = mt_rand(1, $amount);
                        
                        if (mt_rand(0, 100) < $t[2]) {
                            $inv->setItem($i, Item::get($t[0], 0, $amount));
                            $i++;
                        }
                    }
                    break;
                }
            }
        }
    }

}
