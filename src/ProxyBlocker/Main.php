<?php
namespace ProxyBlocker;

use pocketmine\Player;

class Main extends \pocketmine\plugin\PluginBase {

    private $server;
    public function onEnable()
    {
        ($this->server = $this->getServer())->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->server->getLogger()->info("ProxyBlocker is now enabled.");
    }
    
    public function checkForProxy(Player $player)
    {
        $this->server->getScheduler()->scheduleAsyncTask(new ProxyChecker([$player->getAddress(), $player->getName()]));
    }
}
