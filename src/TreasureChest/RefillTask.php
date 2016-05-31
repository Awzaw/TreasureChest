<?php

namespace TreasureChest;

use pocketmine\scheduler\PluginTask;
use pocketmine\math\Vector3;
use pocketmine\item\Item;
use pocketmine\tile\Chest;
use pocketmine\level\Level;

class RefillTask extends PluginTask {

    public function onRun($tick) {

        foreach ($this->getOwner()->config->getAll() as $c => $chestmode) {
            $c = explode(":", $c);
            if (!(($lev = $this->getOwner()->getServer()->getLevelByName($c[3])) instanceof Level))
                continue;
            $tile = $lev->getTile(new Vector3($c[0], $c[1], $c[2]));
            if (!$tile)
                continue;
            if (!($tile instanceof Chest))
                continue;

            $inv = $tile->getRealInventory();

            foreach ($this->getOwner()->treasure->getAll() as $treasure => $tarray) {
       
                if ($treasure === $chestmode) {
                    $i = 0;
                    foreach ($tarray as $tstring) {
                        $t = explode(":", $tstring);
   
                        if (mt_rand(0, 100) < $t[2]) {
                            $inv->setItem($i, new Item($t[0], 0, $t[1]));
                            $i++;
                        }
                    }
                    break;
                }
            }
        }
        //$this->getOwner()->getLogger()->info("Treasure chests have been filled");
    }

}
