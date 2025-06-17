<?php
declare(strict_types=1);

namespace customiesdevs\customies;

use customiesdevs\customies\block\CustomiesBlockFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\scheduler\ClosureTask;
use pocketmine\utils\SingletonTrait;

final class Customies extends PluginBase {
    use SingletonTrait;

    protected function onLoad(): void
    {
        self::setInstance($this);
    }

    public function enable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new CustomiesListener(), $this);

        $cachePath = $this->getDataFolder() . "idcache";
        $this->getScheduler()->scheduleDelayedTask(new ClosureTask(static function () use ($cachePath): void {
            // This task is scheduled with a 0-tick delay so it runs as soon as the server has started. Plugins should
            // register their custom blocks and entities in onEnable() before this is executed.
            CustomiesBlockFactory::getInstance()->addWorkerInitHook($cachePath);
        }), 1);
    }
}
