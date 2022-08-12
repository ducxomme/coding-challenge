<?php
declare(strict_types=1);

namespace CodingChallenge\Application;

use CodingChallenge\Domain\FoodTruckListGetResult;
use CodingChallenge\Domain\IFoodTruckRepository;
use CodingChallenge\Domain\IGoogleRepository;

/**
 * class IFoodTruckListGetApplicationService
 */
interface IFoodTruckListGetApplicationService
{
    /**
     * @param IFoodTruckRepository $foodTruckRepository
     * @param IGoogleRepository $googleRepository
     */
    public function __construct(
        IFoodTruckRepository $foodTruckRepository,
        IGoogleRepository $googleRepository
    );

    /**
     * @param FoodTruckListGetCommand $command
     * @return FoodTruckListGetResult
     */
    public function handle(FoodTruckListGetCommand $command): FoodTruckListGetResult;
}
