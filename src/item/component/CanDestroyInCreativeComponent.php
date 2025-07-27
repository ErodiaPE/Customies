<?php
declare(strict_types=1);

namespace customiesdevs\customies\item\component;

final class CanDestroyInCreativeComponent extends PropertyComponent
{

	private bool $canDestroyInCreative;

	/**
	 * Determines if the item will break blocks in Creative Mode while swinging.
	 * @param bool $canDestroyInCreative Default is set to `true`
	 */
	public function __construct(bool $canDestroyInCreative = true) {
		$this->canDestroyInCreative = $canDestroyInCreative;
	}

	public function getName(): string {
		return "minecraft:can_destroy_in_creative";
	}

	public function getValue(): bool {
		return $this->canDestroyInCreative;
	}

	public function isProperty(): bool {
		return true;
	}
}
