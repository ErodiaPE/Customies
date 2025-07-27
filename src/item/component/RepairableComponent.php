<?php

namespace customiesdevs\customies\item\component;

class RepairableComponent implements ItemComponent
{
    /**
     * @param array $items
     * @param string|int $amount
     */
    public function __construct(
        private array $items,
        private string|int $amount = "math.min(q.remaining_durability + c.other->q.remaining_durability + math.floor(q.max_durability /20), c.other->q.max_durability)"
    ) {}

    /**
     * @return string
     */
    public function getName(): string
    {
        return "minecraft:repairable";
    }

    /**
     * @return mixed
     */
    public function getValue(): mixed
    {
        return [
            "repair_items" => [
                "items" => $this->items,
                "amount" => $this->amount
            ]
        ];
    }

    /**
     * @return bool
     */
    public function isProperty(): bool
    {
        return false;
    }
}