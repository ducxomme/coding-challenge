<?php
declare(strict_types=1);

namespace CodingChallenge\Infrastructure;

use CodingChallenge\Domain\Address;
use CodingChallenge\Domain\FoodItem;
use CodingChallenge\Domain\FoodTruck;
use CodingChallenge\Domain\FoodTruckCollection;
use CodingChallenge\Domain\Id;
use CodingChallenge\Domain\IFoodTruckRepository;
use CodingChallenge\Domain\Latitude;
use CodingChallenge\Domain\Location;
use CodingChallenge\Domain\Longitude;
use CodingChallenge\Infrastructure\Common\ApiClient;
use Exception;

/**
 *
 */
final class FoodTruckRepository implements IFoodTruckRepository
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function get(): FoodTruckCollection
    {
        $baseUrl = 'https://data.sfgov.org/resource/rqzj-sfat.json';

        $query = 'SELECT objectid, address, latitude, longitude, foodItems WHERE longitude IS NOT NULL AND latitude IS NOT NULL';
        $encodedConditions = urlencode($query);

        $params = '$query=' . $encodedConditions;

        $records = ApiClient::get("$baseUrl?{$params}");

        $collection = new FoodTruckCollection();

        foreach ($records as $record) {
            $entity = FoodTruck::create();

            $entity->setId(new Id($record['objectid']));
            $entity->setAddress(new Address($record['address']));
            $entity->setLatitude(new Latitude((float)$record['latitude']));
            $entity->setLongitude(new Longitude((float)$record['longitude']));
            // $entity->setFoodItem(new FoodItem($record['foodItems']));

            $collection->add($entity);
        }

        return $collection;
    }

    /**
     * @inheritDoc
     */
    public function getNearFoodTrucks(FoodTruckCollection $foodTrucks,
                                      ?Location $location): FoodTruckCollection
    {
        return $foodTrucks;
    }
}
