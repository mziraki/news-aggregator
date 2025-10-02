<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(protected ArticleService $service) {}

    public function index(ArticleIndexRequest $request)
    {
        return ArticleResource::collection($this->service->getArticles($request->validated()));
    }
}
