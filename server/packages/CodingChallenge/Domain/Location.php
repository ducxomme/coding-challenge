<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 * Class Location
 * @package CodingChallenge\Domain
 */
final class Location
{
    /**
     * @var Latitude|null
     */
    private ?Latitude $latitude;

    /**
     * @var Longitude|null
     */
    private ?Longitude $longitude;

    /**
     *
     */
    public function __construct()
    {
        $this->latitude = null;
        $this->longitude = null;
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
}
