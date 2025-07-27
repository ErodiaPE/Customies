<?php

namespace customiesdevs\customies\block\component;

use customiesdevs\customies\util\NBT;
use pocketmine\nbt\tag\CompoundTag;

class LiquidDetectionComponent implements BlockComponent
{
    public function __construct(
        private string $liquidType = "water", // Default liquid type
        private bool $can_contain_liquid = true, // Whether the block is waterloggable
        private string $on_liquid_touches = "no_reaction", // Action when liquid touches the block
    ) {}

    public function getName(): string
    {
        return "minecraft:liquid_detection";
    }

    public function getValue(): CompoundTag
    {
        $data = [
            "detection_rules" => [
                "liquid_type" => $this->liquidType,
                "can_contain_liquid" => $this->can_contain_liquid,
                "on_liquid_touches" => $this->on_liquid_touches,
            ],
        ];

        /** @var CompoundTag $tag */
        $tag = NBT::getTagType($data);
        return $tag;
    }
}