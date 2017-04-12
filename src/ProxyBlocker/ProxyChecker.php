<?php
namespace ProxyBlocker;

use pocketmine\Player;
use pocketmine\scheduler\AsyncTask;
use pocketmine\Server;
use pocketmine\utils\TextFormat as TF;

class ProxyChecker extends AsyncTask {

    private $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function onRun()
    {
        $api = "http://legacy.iphub.info/api.php?ip=" . $this->data[0] . "&showtype=4&email=" . $this->data[2];
        $api = json_decode(file_get_contents($api));
        $check = $api->proxy == 1;
        $msg = TF::GOLD . "Please turn your VPN off if you want to continue playing.";
        $this->setResult([
            $check,
            str_repeat(" ", strlen($msg) / 2.25) . TF::RED . "VPN Detected." . PHP_EOL . $msg,
            TF::ITALIC . TF::GRAY . "Kicked " . TF::AQUA . $this->data[1] . TF::GRAY . " for using a proxy."
        ]);
    }

    public function onCompletion(Server $server)
    {
        if (($res = $this->getResult())[0]) {
            $server->getPlayerExact($this->data[1])->kick($res[1], false);
            foreach (array_keys($server->getOps()->getAll()) as $op) {
                $pl = $server->getPlayer($op);
                if ($pl instanceof Player) {
                    $pl->sendMessage($res[2]);
                }
            }
        }
    }
}
