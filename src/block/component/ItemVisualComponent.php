<?php

namespace customiesdevs\customies\block\component;

use customiesdevs\customies\block\Material;
use pocketmine\nbt\tag\CompoundTag;

class ItemVisualComponent implements BlockComponent
{
    /**
     * @param string $geometry
     * @param Material[] $materials
     */
    public function __construct(
        private string $geometry = "minecraft:geometry.full_block",
        private array $materials = []
    ) {}

    /**
     * Sets the item visual component for a block.
     * This component is used to define how the item looks when held in the player's hand.
     *
     * @return string
     */
    public function getName(): string
    {
        return "minecraft:item_visual";
    }

    public function getValue(): CompoundTag
    {
        $materials = CompoundTag::create();
        foreach($this->materials as $material){
            $materials->setTag($material->getTarget(), $material->toNBT());
        }

        return CompoundTag::create()
            ->setString("geometry", $this->geometry)
            ->setTag("materials", $materials);
    }
}