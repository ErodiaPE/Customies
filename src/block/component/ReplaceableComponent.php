<?php

namespace customiesdevs\customies\block\component;

use pocketmine\nbt\tag\CompoundTag;

class ReplaceableComponent implements BlockComponent
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return "minecraft:replaceable";
    }

    /**
     * @return CompoundTag
     */
    public function getValue(): CompoundTag
    {
        return CompoundTag::create();
    }
}