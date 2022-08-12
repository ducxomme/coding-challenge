<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * class IFoodTruckRepository
 */
interface IFoodTruckRepository
{
    /**
     * @return FoodTruckCollection
     */
    public function get(): FoodTruckCollection;

    /**
     * @param FoodTruckCollection $foodTrucks
     * @param Location $location
     * @return FoodTruckCollection
     */
    public function getNearFoodTrucks(FoodTruckCollection $foodTrucks,
                                      Location $location): FoodTruckCollection;
}
