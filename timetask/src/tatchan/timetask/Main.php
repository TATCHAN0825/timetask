<?php

namespace tatchan\timetask;

use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\Task;

class Main extends PluginBase
{

	public function onEnable(): void
	{

	}

	public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool
	{
		switch ($command->getName()) {
			case "timer":
				$this->getScheduler()->scheduleRepeatingTask(new TimeTask($this, $sender, 100), 20);
				return true;
			default:
				return false;
		}
	}

}

class TimeTask extends Task
{
	private $owner;
	private $player;
	private $second;

	public function __construct(Plugin $owner, Player $player, int $second)
	{ //引き継がない場合は$ownerだけで大丈夫です
		$this->owner = $owner;
		$this->player = $player;
		$this->second = $second;
	}

	public function onRun(int $ticks)
	{
		$player = $this->player; //プレイヤー取得
		$this->second;
		$this->second--;
		if ($this->second > 0) {
			$player->sendMessage("$this->second");
		} else {
			$player->sendMessage("カウントダウン終了");
			$this->getHandler()->cancel();
		}
	}
}
