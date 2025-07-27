<?php
declare(strict_types=1);

namespace customiesdevs\customies\item\component;

final class GlintComponent extends PropertyComponent
{

	private bool $glint;

	/**
	 * Determines whether the item has the enchanted glint render effect on it.
	 * @param bool $glint Default is set to `true`
	 */
	public function __construct(bool $glint = true) {
		$this->glint = $glint;
	}

	public function getName(): string {
		return "minecraft:foil";
	}

	public function getValue(): bool {
		return $this->glint;
	}

	public function isProperty(): bool {
		return true;
	}
}