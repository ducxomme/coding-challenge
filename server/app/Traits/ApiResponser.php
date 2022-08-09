<?php

namespace App\Traits;

// use Illuminate\Support\Collection;
// use Illuminate\Support\Facades\Cache;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Support\Facades\Validator;
// use Illuminate\Pagination\LengthAwarePaginator;

trait ApiResponser{

	protected function errorResponse($message = null, $code)
	{
		$requestId = $_SERVER['HTTP_REQUEST_ID'] ?? 'no-request-id';
		return response()->json([
			'requestId' => $requestId,
			'status'=>'Error',
			'message' => $message,
			'data' => null
		], $code);
	}
}
