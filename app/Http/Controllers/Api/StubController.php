<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class StubController extends Controller
{
    public function notImplemented(Request $request): JsonResponse
    {
        return response()->json([
            'message' => 'Endpoint scaffold: implement in a follow-up iteration.',
            'method' => $request->method(),
            'path' => $request->path(),
        ], 501);
    }
}
