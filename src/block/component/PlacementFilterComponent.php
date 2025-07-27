<?php

namespace customiesdevs\customies\block\component;

use customiesdevs\customies\util\NBT;
use pocketmine\nbt\tag\CompoundTag;

class PlacementFilterComponent implements BlockComponent
{
    public function __construct(
        private array $allowedFaces = [],
        private array $block_filter = [],
    )
    {
    }

    public function getName(): string
    {

        return "minecraft:placement_filter";
    }

    public function getValue(): CompoundTag
    {
        $data = [
            "conditions" => [
                "allowed_faces" => $this->allowedFaces,
                "block_filter" => $this->block_filter,
            ],
        ];

        /** @var CompoundTag $tag */
        $tag = NBT::getTagType($data);
        return $tag;
    }
}