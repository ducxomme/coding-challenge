<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * Class FoodTruck
 * @package CodingChallenge\Domain
 */
final class FoodTruck
{
    /**
     * @var Id|null
     */
    private ?Id $id;

    /**
     * @var Address|null
     */
    private ?Address $address;

    /**
     * @var Latitude|null
     */
    private ?Latitude $latitude;

    /**
     * @var Longitude|null
     */
    private ?Longitude $longitude;

    /**
     * @var FoodItem|null
     */
    private ?FoodItem $foodItem;

    private function __construct()
    {
        $this->id = null;
        $this->address = null;
        $this->latitude = null;
        $this->longitude = null;
        $this->foodItem = null;
    }

    /**
     * @return FoodTruck
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     * @return Id|null
     */
    public function getId(): ?Id
    {
        return $this->id;
    }

    /**
     * @param Id|null $id
     */
    public function setId(?Id $id): void
    {
        $this->id = $id;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Latitude|null
     */
    public function getLatitude(): ?Latitude
    {
        return $this->latitude;
    }

    /**
     * @param Latitude|null $latitude
     */
    public function setLatitude(?Latitude $latitude): void
    {
        $this->latitude = $latitude;
    }

    /**
     * @return Longitude|null
     */
    public function getLongitude(): ?Longitude
    {
        return $this->longitude;
    }

    /**
     * @param Longitude|null $longitude
     */
    public function setLongitude(?Longitude $longitude): void
    {
        $this->longitude = $longitude;
    }

    /**
     * @return FoodItem|null
     */
    public function getFoodItem(): ?FoodItem
    {
        return $this->foodItem;
    }

    /**
     * @param FoodItem|null $foodItem
     */
    public function setFoodItem(?FoodItem $foodItem): void
    {
        $this->foodItem = $foodItem;
    }
}
