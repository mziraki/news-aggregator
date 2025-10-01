<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryResource;
use App\Repositories\Contracts\ArticleRepositoryInterface;

class CategoryController extends Controller
{
    public function __construct(protected ArticleRepositoryInterface $articles) {}

    public function index()
    {
        return CategoryResource::collection($this->articles->getCategories());
    }
}
