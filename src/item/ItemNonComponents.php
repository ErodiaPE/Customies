<?php
declare(strict_types=1);

namespace customiesdevs\customies\item;

use customiesdevs\customies\item\component\PropertyComponent;
use pocketmine\nbt\tag\CompoundTag;

interface ItemNonComponents
{

    /**
     * Add component adds a component to the item that can be returned in the getComponents() method to be sent over
     * the network.
     */
    public function addProperty(PropertyComponent $component): self;

    /**
     * Returns if the item has the component with the provided name.
     */
    public function hasProperty(string $name): bool;

    /**
     * Returns the fully-structured CompoundTag that can be sent to a client in the ItemComponentsPacket.
     */
    public function getProperties(): CompoundTag;

    public function buildProperties(): void;
}