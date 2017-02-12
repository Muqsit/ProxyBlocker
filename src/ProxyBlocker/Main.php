<?php
namespace ProxyBlocker;

use pocketmine\Player;

class Main extends \pocketmine\plugin\PluginBase {

    private $server, $email;
    public function onEnable()
    {
        ($this->server = $this->getServer())->getPluginManager()->registerEvents(new EventListener($this), $this);
        $this->server->getLogger()->info("ProxyBlocker is now enabled.");
        $random = "email".mt_rand(0, 10).mt_rand(0, 10).mt_rand(0, 10).mt_rand(0, 10)."@".["gmail.com", "yahoo.com", "hotmail.com"][mt_rand(0, 2)];
        $this->email = yaml_parse_file($this->getDataFolder()."config.yml")["email"] ?? $random;
    }
    
    public function checkForProxy(Player $player)
    {
        $this->server->getScheduler()->scheduleAsyncTask(new ProxyChecker([$player->getAddress(), $player->getName(), $this->email]));
    }
}
