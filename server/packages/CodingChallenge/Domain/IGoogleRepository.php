<?php
declare(strict_types=1);

namespace CodingChallenge\Domain;

/**
 *
 */
interface IGoogleRepository
{
    /**
     * @param string $address
     * @return Location|null
     */
    public function getLocation(string $address): ?Location;
}
