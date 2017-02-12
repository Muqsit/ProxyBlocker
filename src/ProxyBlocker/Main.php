<?php
namespace ProxyBlocker;

class Main extends \pocketmine\plugin\PluginBase {

    private $server;
    public function onEnable()
    {
        ($this->server = $this->getServer())->getPluginManager()->registerEvents(new EventListener, $this);
        $this->server->getLogger()->info("ProxyBlocker is now enabled.");
    }
}
