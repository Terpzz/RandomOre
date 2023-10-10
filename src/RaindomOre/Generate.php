<?php

namespace RaindomOre;

use pocketmine\plugin\PluginBase;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\block\Lava;
use pocketmine\block\Water;
use pocketmine\block\VanillaBlocks;

class Generate extends PluginBase {

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents(new OreGenerator($this), $this);
    }
}

class OreGenerator {
    private $plugin;

    public function __construct(Generate $plugin) {
        $this->plugin = $plugin;
    }

    public function onBlockSet(BlockUpdateEvent $event) {
        $block = $event->getBlock();

        if ($block instanceof Lava) {
            $waterNearby = false;

            for ($x = -2; $x <= 2; $x++) {
                for ($z = -2; $z <= 2; $z++) {
                    $nearBlock = $block->getSide($x, 0, $z);
                    if ($nearBlock instanceof Water) {
                        $waterNearby = true;
                        break;
                    }
                }
                if ($waterNearby) {
                    break;
                }
            }

            if ($waterNearby) {
                $this->generateOres($block);
            }
        }
    }

    private function generateOres($block) {
        $oreBlocks = [
            VanillaBlocks::IRON_ORE(),
            VanillaBlocks::GOLD_ORE(),
            VanillaBlocks::EMERALD_ORE(),
            VanillaBlocks::COAL_ORE(),
            VanillaBlocks::REDSTONE_ORE(),
            VanillaBlocks::DIAMOND_ORE(),
            VanillaBlocks::LAPIS_LAZULI_ORE(),
        ];

        $newBlock = $oreBlocks[array_rand($oreBlocks)];

        $world = $block->getPosition()->getWorld();
        $world->setBlock($block->getPosition(), $newBlock, true);
    }
}
