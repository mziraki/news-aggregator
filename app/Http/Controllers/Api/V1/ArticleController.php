<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Contracts\ArticleServiceContract;

class ArticleController extends Controller
{
    public function __construct(protected ArticleServiceContract $service) {}

    public function index(ArticleIndexRequest $request)
    {
        return ArticleResource::collection($this->service->getArticles($request->validated()));
    }
}
