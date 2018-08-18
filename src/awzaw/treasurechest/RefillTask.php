<?php

namespace awzaw\treasurechest;

use pocketmine\item\ItemFactory;
use pocketmine\scheduler\Task;
use pocketmine\math\Vector3;
use pocketmine\tile\Chest;
use pocketmine\level\Level;

class RefillTask extends Task {

	public function __construct(Main $plugin){
		    $this->plugin = $plugin;
	 	}

    public function onRun(int $tick) {

        foreach ($this->plugin->getChests()->getAll() as $c => $chestmode) {
            $c = explode(":", $c);
            if (!(($lev = $this->plugin->getServer()->getLevelByName($c[3])) instanceof Level))
                continue;
            $tile = $lev->getTile(new Vector3((int) $c[0], (int) $c[1], (int) $c[2]));
            if (!$tile)
                continue;
            if (!($tile instanceof Chest))
                continue;

            $tile->getInventory()->clearAll();
            $inv = $tile->getInventory();

            foreach ($this->plugin->treasure->getAll() as $treasure => $tarray) {

                if ($treasure === $chestmode) {
                    $i = 0;
                    foreach ($tarray as $tstring) {
                        $t = explode(":", $tstring);
                        
                        $amount = $t[1];
                        if ($this->plugin->prefs->get("RandomizeAmount"))
                            $amount = mt_rand(1, $amount);
                        
                        if (mt_rand(0, 100) < $t[2]) {
                            $inv->setItem($i, ItemFactory::get($t[0], 0, $amount));
                            $i++;
                        }
                    }
                    break;
                }
            }
        }
    }

}
