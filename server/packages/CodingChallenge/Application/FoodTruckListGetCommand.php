<?php
declare(strict_types=1);

namespace CodingChallenge\Application;

/**
 * class FoodTruckListGetCommand
 */
final class FoodTruckListGetCommand
{
    /**
     * @var string|null
     */
    private ?string $address;

    /**
     * FoodTruckListGetCommand constructor
     */
    public function __construct()
    {
        $this->address = null;
    }

    /**
     * @return string|null
     */
    public function getAddress(): ?string
    {
        return $this->address;
    }

    /**
     * @param string|null $address
     */
    public function setAddress(?string $address): void
    {
        $this->address = $address;
    }
}
