<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * Class FoodTruckListGetResult
 * @package CodingChallenge\Domain
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
        $data = [];

        foreach ($this->collection->getEntities() as $entity) {
            $data[] = [
                'id' => $entity->getId()->getId(),
                'address' => $entity->getAddress()->getValue(),
                'latitude' => $entity->getLatitude()->getValue(),
                'longitude' => $entity->getLongitude()->getValue(),
//                'foodItem' => $entity->getFoodItem()->getValue(),
            ];
        }

        return [
            'data' => $data,
        ];
    }
}
