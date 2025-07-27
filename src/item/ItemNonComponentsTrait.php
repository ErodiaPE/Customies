<?php
declare(strict_types=1);

namespace customiesdevs\customies\item;

use customiesdevs\customies\item\component\AllowOffHandComponent;
use customiesdevs\customies\item\component\CanDestroyInCreativeComponent;
use customiesdevs\customies\item\component\CreativeCategoryComponent;
use customiesdevs\customies\item\component\CreativeGroupComponent;
use customiesdevs\customies\item\component\DamageComponent;
use customiesdevs\customies\item\component\FoodComponent;
use customiesdevs\customies\item\component\HandEquippedComponent;
use customiesdevs\customies\item\component\ItemComponent;
use customiesdevs\customies\item\component\MaxStackSizeComponent;
use customiesdevs\customies\item\component\PropertyComponent;
use customiesdevs\customies\item\component\UseAnimationComponent;
use customiesdevs\customies\item\component\UseDurationComponent;
use customiesdevs\customies\util\NBT;
use pocketmine\entity\Consumable;
use pocketmine\item\Food;
use pocketmine\item\Sword;
use pocketmine\item\Tool;
use pocketmine\nbt\tag\CompoundTag;
use RuntimeException;

trait ItemNonComponentsTrait {

	/** @var ItemComponent[] */
	private array $properties;

	public function addProperty(PropertyComponent $component): ItemNonComponents
    {
		$this->properties[$component->getName()] = $component;
        return $this;
	}

	public function hasProperty(string $name): bool {
		return isset($this->properties[$name]);
	}

	public function getProperties(): CompoundTag {
		$components = CompoundTag::create();
		foreach($this->properties as $component){
			$tag = NBT::getTagType($component->getValue());
			if($tag === null) {
				throw new RuntimeException("Failed to get tag type for component " . $component->getName());
			}
			$components->setTag($component->getName(), $tag);
		}
		return CompoundTag::create()
			->setTag("components", $components);
	}

    abstract public function buildProperties(): void;

    /**
     * @param string $texture
     * @param CreativeInventoryInfo|null $creativeInfo
     * @return \Erodia\Container\Item\Property\Key\ArseKey|mixed|Consumable|Food|Sword|Tool
     */
    protected function buildDefault(?CreativeInventoryInfo $creativeInfo = null): ItemNonComponents
    {
        $creativeInfo ??= CreativeInventoryInfo::DEFAULT();
        $this->addProperty(new CreativeCategoryComponent($creativeInfo));
        $this->addProperty(new CreativeGroupComponent($creativeInfo));
        $this->addProperty(new CanDestroyInCreativeComponent());
        $this->addProperty(new MaxStackSizeComponent($this->getMaxStackSize()));

        if($this instanceof Consumable) {
            if(($food = $this instanceof Food)) {
                $this->addProperty(new FoodComponent(!$this->requiresHunger()));
            }
            $this->addProperty(new UseAnimationComponent($food ? UseAnimationComponent::ANIMATION_EAT : UseAnimationComponent::ANIMATION_DRINK));
            $this->setUseDuration(20);
        }

        if($this->getAttackPoints() > 0) {
            $this->addProperty(new DamageComponent($this->getAttackPoints() - 1));
        }

        if($this instanceof Tool) {
            $this->addProperty(new HandEquippedComponent());
            if ($this instanceof Sword) {
                $this->addProperty(new CanDestroyInCreativeComponent(false));
            }
        }

        return $this;
    }

	/**
	 * Change if you want to allow the item to be placed in a player's off-hand or not. This is set to false by default,
	 * so it only needs to be set if you want to allow it.
	 */
	protected function allowOffHand(bool $offHand = true): void {
		$this->addProperty(new AllowOffHandComponent($offHand));
	}

	/**
	 * Set the number of ticks the use animation should play for before consuming the item. There are 20 ticks in a
	 * second, so providing the number 20 will create a duration of 1 second.
	 */
	protected function setUseDuration(int $ticks): void {
		$this->addProperty(new UseDurationComponent($ticks));
	}
}
