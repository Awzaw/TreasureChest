<?php

namespace TreasureChest;

use pocketmine\command\Command;
use pocketmine\command\CommandExecutor;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\math\Vector3;
use pocketmine\utils\TextFormat;

class ChestRefill extends PluginBase implements CommandExecutor, Listener {

    private $c;
    public $config;

    public function onEnable() {
        $this->c = [];
        if (!is_file($this->getDataFolder() . "/config.txt")) {
            @mkdir($this->getDataFolder());
            file_put_contents($this->getDataFolder() . "/config.txt", 60);
        }
        $this->getServer()->getScheduler()->scheduleRepeatingTask(new RefillTask($this), file_get_contents($this->getDataFolder() . "/config.txt") * 20);
        $this->config = new Config($this->getDataFolder() . "chests.yml", Config::YAML, array());
        $this->treasure = new Config($this->getDataFolder() . "treasure.yml", Config::YAML, array("common" => array("4:64:80", "5:64:80", "17:64:80"), "uncommon" => array("4:64:40", "5:64:40", "17:64:40"), "rare" => array("264:64:5", "276:1:10", "100:16:20")));
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onCommand(CommandSender $sender, Command $cmd, $label, array $args) {
        if ($sender instanceof Player) {
            if (!isset($args[0])) {
                $sender->sendMessage(TEXTFORMAT::RED . "Please type /tc common||uncommon||rare or /tc list");
                return true;
            }

            switch ($args[0]) {
                case "list":
                    $sender->sendMessage(TEXTFORMAT::YELLOW . "Chestmodes");
                    foreach ($this->treasure as $treasure) {
                        $sender->sendMessage(TEXTFORMAT::GREEN . $treasure);
                    }
                    break;

                //more commands here...

                default:
                    break;
            }

            $this->c[$sender->getName()] = $args[0];
            $sender->sendMessage(TEXTFORMAT::GREEN . "Touch a chest to make it a treasure chest");
        } else {
            $sender->sendMessage(TEXTFORMAT::RED . "Please run the command in the game");
        }
        return true;
    }

    public function onPlayerInteract(PlayerInteractEvent $event) {
        if (isset($this->c[$event->getPlayer()->getName()]) && $event->getBlock()->getID() == 54) {
            $tile = $event->getPlayer()->getLevel()->getTile(new Vector3($event->getBlock()->x, $event->getBlock()->y, $event->getBlock()->z));

            $chestmode = $this->c[$event->getPlayer()->getName()];

            $this->config->set($event->getBlock()->x . ":" . $event->getBlock()->y . ":" . $event->getBlock()->z . ":" . $event->getPlayer()->getLevel()->getName(), $chestmode);
            $this->config->save();
            $event->getPlayer()->sendMessage(TEXTFORMAT::GREEN . "Treasure Chest Created in Mode: " . $chestmode);
            unset($this->c[$event->getPlayer()->getName()]);
        }
    }

}
