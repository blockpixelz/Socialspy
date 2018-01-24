<?php
namespace SocialSpy;
use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\Player;
use pocketmine\utils\TextFormat;
use pocketmine\level\Position;
use pocketmine\level\Level;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\player\PlayerChatEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerCommandPreprocessEvent;
use SocialSpy\Commands\CommandSpy;
class Main extends PluginBase implements Listener {
	
	public $prefix = "§8[§aSocialSpy§8]§6 ";
	
	public $commandspy = array();
	
	public function onEnable() {
		$this->getServer()->getPluginManager()->registerEvents($this, $this);
		$this->registerCommands();
	}
	private function registerCommands() {
	        $map = $this->getServer()->getCommandMap();
			$map->register("commandspy", new CommandSpy($this));
	}
    
	/*
	 * Spy on peoples commands...
	 */
    public function onCommandProcess(PlayerCommandPreprocessEvent $e){
        foreach($this->getServer()->getOnlinePlayers() as $p){
            if($this->hasCommandSpy($e->getPlayer())){
                $p->sendMessage(TextFormat::YELLOW . TextFormat::ITALIC . $e->getPlayer()->getName() . ": /" . $e->getMessage());
            }
        }
        
        public function hasCommandSpy($player) {
            return in_array($player->getName(), $this->commandspy);
        }
    
        public function disableCommandSpy($player) {
            $this->commandspy[$player->getName()] = $player->getName();
        }
    
        public function enableCommandSpy($player) {
            unset($this->commandspy[$player->getName()]);
        }
}
