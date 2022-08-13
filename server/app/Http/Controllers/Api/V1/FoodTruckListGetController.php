<?php
declare(strict_types=1);

namespace App\Http\Controllers\Api\V1;

use CodingChallenge\Application\FoodTruckListGetApplicationService;
use CodingChallenge\Application\FoodTruckListGetCommand;
use CodingChallenge\Infrastructure\FoodTruckRepository;
use CodingChallenge\Infrastructure\GoogleRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * class FoodTruckListGetController
 */
final class FoodTruckListGetController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(Request $request): JsonResponse
    {
        $command = new FoodTruckListGetCommand();
        $command->setAddress($request->query('address'));

        $service = new FoodTruckListGetApplicationService(
            new FoodTruckRepository(),
            new GoogleRepository()
        );

        $result = $service->handle($command);

        return response()->json($result->toArray());
    }
}
