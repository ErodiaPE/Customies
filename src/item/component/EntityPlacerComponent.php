<?php
declare(strict_types=1);

namespace customiesdevs\customies\item\component;

final class EntityPlacerComponent implements ItemComponent
{

    private string $entityType;

    public function __construct(string $entityType)
    {
        $this->entityType = $entityType;
    }

    public function getName(): string {
        return "minecraft:entity_placer";
    }

    public function getValue(): array {
        return [
            "entity" => $this->entityType
        ];
    }

    public function isProperty(): bool {
        return false;
    }
}