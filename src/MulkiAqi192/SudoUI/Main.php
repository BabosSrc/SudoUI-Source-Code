<?php

namespace MulkiAqi192\SudoUI;

use pocketmine\Player;

use pocketmine\plugin\PluginBase;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;

use pocketmine\event\Listener;

class Main extends PluginBase implements Listener {

	public function onEnable(){

	}

	public function onCommand(CommandSender $sender, Command $cmd, String $label, Array $args) : bool {

		switch($cmd->getName()){
			case "sudo":
			 if($sender instanceof Player){
			 	if($sender->hasPermission("sudo.use")){
			 		$this->sudo($sender);
			 	} else {
			 		$sender->sendMessage("You dont have permission to do this!");
			 	}
			 }
		}
	return true;
	}

	public function sudo($player){
		$form = $this->getServer()->getPluginManager()->getPlugin("FormAPI")->createCustomForm(function (Player $player, array $data = null){
			if($data === null){
				return true;
			}
			$p = $this->getServer()->getPlayer($data[0]);
			$cmd = $data[1];
			if($p instanceof Player){
				$this->getServer()->dispatchCommand($p, $cmd);
				$player->sendMessage("You sudo " . $p->getName() . " todo /". $data[1]);
			}
		});
		$form->setTitle("SudoUI");
		$form->addInput("Type a player name");
		$form->addInput("Type a command without /");
		$form->sendToPlayer($player);
		return $form;
	}

}