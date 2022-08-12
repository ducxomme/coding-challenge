<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 *
 */
final class FoodTruckListGetResult
{
    /**
     * @var FoodTruckCollection
     */
    private FoodTruckCollection $collection;

    /**
     * @param FoodTruckCollection $collection
     */
    public function __construct(FoodTruckCollection $collection)
    {
        $this->collection = $collection;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [];
    }
}
