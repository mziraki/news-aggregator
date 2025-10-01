<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Models\Article;
use App\Repositories\Contracts\ArticleRepositoryInterface;

class ArticleController extends Controller
{
    public function __construct(protected ArticleRepositoryInterface $articles) {}

    public function index(ArticleIndexRequest $request)
    {
        return ArticleResource::collection($this->articles->search($request->validated()));
    }

    public function show(Article $article)
    {
        return new ArticleResource($article);
    }
}
