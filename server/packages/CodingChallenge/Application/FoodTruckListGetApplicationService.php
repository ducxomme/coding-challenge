<?php
declare(strict_types=1);

namespace CodingChallenge\Application;

use CodingChallenge\Domain\FoodTruckListGetResult;
use CodingChallenge\Domain\IFoodTruckRepository;
use CodingChallenge\Domain\IGoogleRepository;

/**
 * class FoodTruckListGetApplicationService
 */
final class FoodTruckListGetApplicationService implements IFoodTruckListGetApplicationService
{
    /**
     * @var IFoodTruckRepository
     */
    private IFoodTruckRepository $foodTruckRepository;

    /**
     * @var IGoogleRepository
     */
    private IGoogleRepository $googleRepository;

    /**
     * @inheritDoc
     */
    public function __construct(
        IFoodTruckRepository $foodTruckRepository,
        IGoogleRepository $googleRepository
    ) {
        $this->foodTruckRepository = $foodTruckRepository;
        $this->googleRepository = $googleRepository;
    }

    /**
     * @inheritDoc
     */
    public function handle(FoodTruckListGetCommand $command): FoodTruckListGetResult
    {
        // Get all food trucks data (Which have address, long, lat information)
        $foodTrucks = $this->foodTruckRepository->get();

        // Get longitude, latitude from specified address
        $location = null;
        if (!empty($command->getAddress())) {
            $location = $this->googleRepository->getLocation($command->getAddress());
        }

        $nearFoodTrucks = $this->foodTruckRepository->getNearFoodTrucks($foodTrucks, $location);

        return new FoodTruckListGetResult($nearFoodTrucks);
    }
}
