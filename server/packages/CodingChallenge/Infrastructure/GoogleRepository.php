<?php
declare(strict_types=1);

namespace CodingChallenge\Infrastructure;

use CodingChallenge\Domain\Location;
use CodingChallenge\Domain\IGoogleRepository;

/**
 *
 */
final class GoogleRepository implements IGoogleRepository
{
    /**
     * @inheritDoc
     */
    public function getLocation(string $address): Location
    {
        return new Location();
    }
}
