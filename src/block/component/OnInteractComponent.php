<?php

namespace customiesdevs\customies\block\component;

use pocketmine\nbt\tag\CompoundTag;

class OnInteractComponent implements BlockComponent
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "minecraft:on_interact";
    }

    /**
     * @return CompoundTag
     */
    public function getValue(): CompoundTag
    {
        return CompoundTag::create();
    }
}
