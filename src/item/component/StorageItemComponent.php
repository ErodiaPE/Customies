<?php

namespace customiesdevs\customies\item\component;

class StorageItemComponent implements ItemComponent
{
    /**
     * @param int $slots
     * @param string[] $allowed_items
     * @param string[] $banned_items
     * @param bool $allow_nested_storage_items
     */
    public function __construct(
        private int $slots,
        private array $allowed_items = [],
        private array $banned_items = [],
        private bool $allow_nested_storage_items = false,
    )
    {
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return "minecraft:storage_item";
    }

    public function getValue(): mixed
    {
        return [
            "max_slots" => $this->slots,
            "allow_nested_storage_items" => $this->allow_nested_storage_items,
            "allowed_items" => $this->allowed_items,
            "banned_items" => $this->banned_items,
        ];
    }

    public function isProperty(): bool
    {
        // TODO: Implement isProperty() method.
    }
}