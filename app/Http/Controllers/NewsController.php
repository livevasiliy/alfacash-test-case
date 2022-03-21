<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        return response()->json([]);
    }
}
