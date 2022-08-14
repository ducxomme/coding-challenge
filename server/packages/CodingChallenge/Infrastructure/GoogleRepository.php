<?php
declare(strict_types=1);

namespace CodingChallenge\Infrastructure;

use CodingChallenge\Domain\Latitude;
use CodingChallenge\Domain\Location;
use CodingChallenge\Domain\IGoogleRepository;
use CodingChallenge\Domain\Longitude;
use CodingChallenge\Infrastructure\Common\ApiClient;
use Exception;

/**
 * Class GoogleRepository
 * @package CodingChallenge\Infrastructure
 */
final class GoogleRepository implements IGoogleRepository
{
    /**
     * @inheritDoc
     * @throws Exception
     */
    public function getLocation(string $address): Location
    {
        $baseUrl = 'https://maps.googleapis.com/maps/api/geocode/json';
        $key = env('GOOGLE_API_KEY');

        $address = urlencode($address);

        $params = "address=$address&key=$key";

        $location = null;
        $result = ApiClient::get("$baseUrl?{$params}");

        if (!empty($result['results'])) {
            if (!is_null($result['results'][0]['geometry']['location'])) {
                $location = new Location();

                $locationResult = $result['results'][0]['geometry']['location'];

                $location->setLatitude(new Latitude((float)$locationResult['lat']));
                $location->setLongitude(new Longitude((float)$locationResult['lng']));
            }
        }

        return $location;
    }
}
