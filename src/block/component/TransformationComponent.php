<?php

namespace customiesdevs\customies\block\component;

use pocketmine\math\Vector3;
use pocketmine\nbt\tag\CompoundTag;

class TransformationComponent implements BlockComponent {

    /**
     * @param Vector3 $rotation
     * @param Vector3 $scale
     * @param Vector3 $translation
     */
	public function __construct(
        private Vector3 $rotation = new Vector3(0,0,0),
        private Vector3 $scale = new Vector3(1,1,1),
        private Vector3 $translation = new Vector3(0,0,0)
    ) {

	}

	public function getName(): string {
		return "minecraft:transformation";
	}

    /**
     * @return Vector3
     */
    public function getRotation(): Vector3
    {
        return $this->rotation;
    }

    /**
     * @return Vector3
     */
    public function getScale(): Vector3
    {
        return $this->scale;
    }

    /**
     * @return Vector3
     */
    public function getTranslation(): Vector3
    {
        return $this->translation;
    }

    /**
     * @param Vector3 $rotation
     */
    public function setRotation(Vector3 $rotation): void
    {
        $this->rotation = $rotation;
    }

    /**
     * @param Vector3 $scale
     */
    public function setScale(Vector3 $scale): void
    {
        $this->scale = $scale;
    }

    /**
     * @param Vector3 $translation
     */
    public function setTranslation(Vector3 $translation): void
    {
        $this->translation = $translation;
    }

	public function getValue(): CompoundTag {		
		return CompoundTag::create()
            ->setInt("RX", intdiv((int) $this->getRotation()->getX(), 90))
            ->setFloat("RXP", 0)
            ->setInt("RY", intdiv((int) $this->getRotation()->getY(), 90))
            ->setFloat("RYP", 0)
            ->setInt("RZ", intdiv((int) $this->getRotation()->getZ(), 90))
            ->setFloat("RZP", 0)
            ->setFloat("SX", $this->getScale()->getX())
            ->setFloat("SXP", 0)
            ->setFloat("SY", $this->getScale()->getY())
            ->setFloat("SYP", 0)
            ->setFloat("SZ", $this->getScale()->getZ())
            ->setFloat("SZP", 0)
            ->setFloat("TX", $this->getTranslation()->getX())
            ->setFloat("TY", $this->getTranslation()->getY())
            ->setFloat("TZ", $this->getTranslation()->getZ());
	}
}