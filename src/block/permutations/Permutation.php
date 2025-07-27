<?php
declare(strict_types=1);

namespace customiesdevs\customies\block\permutations;

use customiesdevs\customies\block\component\BlockComponent;
use customiesdevs\customies\util\NBT;
use pocketmine\nbt\tag\CompoundTag;

final class Permutation {

	private CompoundTag $components;

	public function __construct(private string $condition) {
		$this->components = CompoundTag::create();
	}

    /**
     * @param string $condition
     * @return self
     */
    public static function create(string $condition = ""): Permutation
    {
        return new self($condition);
    }

    /**
     * @param string $condition
     * @return Permutation
     */
    public function setCondition(string $condition): self
    {
        $this->condition = $condition;
        return $this;
    }

	/**
	 * Returns the permutation with the provided component added to the current list of Components.
	 */
	public function withComponent(string $component, mixed $value) : self {
		$this->components->setTag($component, NBT::getTagType($value));
		return $this;
	}

    /**
     * @param BlockComponent $component
     * @return $this
     */
    public function addComponent(BlockComponent $component): static
    {
        $this->components->setTag($component->getName(), $component->getValue());
        return $this;
    }

	/**
	 * Returns the permutation in the correct NBT format supported by the client.
	 */
	public function toNBT(): CompoundTag {
		return CompoundTag::create()
			->setString("condition", $this->condition)
			->setTag("Components", $this->components);
	}
}