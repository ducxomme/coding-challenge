<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * class FoodTruckCollection
 */
final class FoodTruckCollection
{
    /**
     * @var FoodTruck[]
     */
    private array $entities;

    /**
     * FoodTruckCollection constructor
     */
    public function __construct()
    {
        $this->entities = [];
    }

    /**
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
    }

    /**
     * @param FoodTruck $entity
     * @return void
     */
    public function add(FoodTruck $entity): void
    {
        $this->entities[] = $entity;
    }
}
