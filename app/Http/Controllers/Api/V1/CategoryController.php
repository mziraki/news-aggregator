<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Services\Contracts\CategoryServiceContract;

class CategoryController extends Controller
{
    public function __construct(protected CategoryServiceContract $service) {}

    public function index()
    {
        return CategoryResource::collection($this->service->getCategories());
    }
}
