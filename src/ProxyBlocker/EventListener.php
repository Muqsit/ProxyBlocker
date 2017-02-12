<?php
namespace ProxyBlocker;

use pocketmine\event\player\PlayerLoginEvent;

class EventListener implements \pocketmine\event\Listener {

    private $plugin;
    public function __construct(Main $plugin)
    {
        $this->plugin = $plugin;
    }

    public function onLogin(PlayerLoginEvent $event)
    {
        $this->plugin->checkForProxy($event->getPlayer());
    }
}
