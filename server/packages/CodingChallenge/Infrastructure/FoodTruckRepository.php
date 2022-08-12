<?php
declare(strict_types=1);

namespace CodingChallenge\Infrastructure;

use CodingChallenge\Domain\FoodTruckCollection;
use CodingChallenge\Domain\IFoodTruckRepository;
use CodingChallenge\Domain\Location;

/**
 *
 */
final class FoodTruckRepository implements IFoodTruckRepository
{
    /**
     * @inheritDoc
     */
    public function get(): FoodTruckCollection
    {
        // TODO: Implement get() method.
    }

    /**
     * @inheritDoc
     */
    public function getNearFoodTrucks(FoodTruckCollection $foodTrucks, Location $location): FoodTruckCollection
    {
        // TODO: Implement getNearFoodTrucks() method.
    }
}
