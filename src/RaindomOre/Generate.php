<?php

namespace RaindomOre;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\math\Vector3;
use pocketmine\Player;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\item\Item;
use pocketmine\event\Listener;
use pocketmine\world\World;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\block\Water;
use pocketmine\block\Lava;

class Generate extends PluginBase implements Listener {
    
    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
    }

    public function onBlockSet(BlockUpdateEvent $event) {
        $block = $event->getBlock();
        $water = false;
        $lava = false;
        for ($i = 2; $i <= 5; $i++) {
            $nearBlock = $block->getSide($i);
            if ($nearBlock instanceof Water) {
                $water = true;
            } elseif ($nearBlock instanceof Lava) {
                $lava = true;
            }
            if ($water && $lava) {
                $id = mt_rand(1, 20);
                switch ($id) {
                    case 2:
                        $newBlock = VanillaBlocks::IRON_ORE();
                        break;
                    case 4:
                        $newBlock = VanillaBlocks::GOLD_ORE();
                        break;
                    case 6:
                        $newBlock = VanillaBlocks::EMERALD_ORE();
                        break;
                    case 8:
                        $newBlock = VanillaBlocks::COAL_ORE();
                        break;
                    case 10:
                        $newBlock = VanillaBlocks::REDSTONE_ORE();
                        break;
                    case 12:
                        $newBlock = VanillaBlocks::DIAMOND_ORE();
                        break;
                    case 14:
                        $newBlock = VanillaBlocks::LAPIS_LAZULI_ORE();
                        break;
                    default:
                        $newBlock = VanillaBlocks::COBBLESTONE();
                }
                $block->getWorldManager()->getWorld()->setBlock($block->getPosition(), $newBlock, true, false);
                return;
            }
        }
    }
}
