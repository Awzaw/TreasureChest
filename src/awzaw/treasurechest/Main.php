<?php

namespace awzaw\treasurechest;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\Server;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;
use pocketmine\block\BlockIds;

class Main extends PluginBase implements CommandExecutor, Listener {

    private $c;
    public $prefs;
    public $config;
    public $treasure;

    public function onEnable() {
        $this->c = [];
        if(!is_file($this->getDataFolder() . "/config.txt")) {
            @mkdir($this->getDataFolder());
            file_put_contents($this->getDataFolder() . "/config.txt", 60);
        }
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RefillTask($this), file_get_contents($this->getDataFolder() . "/config.txt") * 20);
        $this->config = new Config($this->getDataFolder() . "chests.yml", Config::YAML, []);
        $this->treasure = new Config($this->getDataFolder() . "treasure.yml", Config::YAML, ["common" => ["4:64:80", "5:64:80", "17:64:80"], "uncommon" => ["4:64:40", "5:64:40", "17:64:40"], "rare" => ["264:64:5", "276:1:10", "100:16:20"]]);
        $this->prefs = new Config($this->getDataFolder() . "prefs.yml", CONFIG::YAML, [
            "RandomizeAmount" => true
        ]);

        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, string  $label, array $args) : bool {
        if($sender instanceof Player) {
            if(!isset($args[0])) {
                $sender->sendMessage(TEXTFORMAT::RED . "Please type /tchest common||uncommon||rare or /tchest list");
                return true;
            }

            switch($args[0]) {
                case "list":
                    $sender->sendMessage(TEXTFORMAT::YELLOW . "Chestmodes");
                    foreach($this->treasure->getAll() as $treasure => $value) {
                        $sender->sendMessage(TEXTFORMAT::GREEN . $treasure);
                    }
                    return true;

                case "off":
                case "stop":
                    unset($this->c[$sender->getPlayer()->getName()]);
                    $sender->sendMessage(TEXTFORMAT::RED . "Treasure Chest Tap Mode : OFF");

                    return true;

                default:
                    break;
            }

            $this->c[$sender->getName()] = $args[0];
            $sender->sendMessage(TEXTFORMAT::GREEN . "TreasureChest Tap Mode : ON");
            $sender->sendMessage(TEXTFORMAT::YELLOW . "Selected ChestMode : $args[0]");
            $sender->sendMessage(TEXTFORMAT::YELLOW . "Touch chests to convert to Treasure Chests, type '/tchest off' to stop");
        } else {
            $sender->sendMessage(TEXTFORMAT::RED . "Please run the command in the game");
        }
        return true;
    }

    public function onPlayerInteract(PlayerInteractEvent $event) {
        if ($event->isCancelled()) return;
        if($event->getBlock()->getID() !== BlockIds::CHEST) return;

        if(isset($this->c[$event->getPlayer()->getName()])) {
            $chestmode = $this->c[$event->getPlayer()->getName()];
            $this->config->set($event->getBlock()->x . ":" . $event->getBlock()->y . ":" . $event->getBlock()->z . ":" . $event->getPlayer()->getLevel()->getName(), $chestmode);
            $this->config->save();
            $event->getPlayer()->sendMessage(TEXTFORMAT::GREEN . "Treasure Chest Set to Chestmode: $chestmode");
            $event->setCancelled(true);
            return true;
        }
    }

}
