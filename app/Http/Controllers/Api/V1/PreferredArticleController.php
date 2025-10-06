<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferredArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Services\Contracts\ArticleServiceContract;

class PreferredArticleController extends Controller
{
    public function __construct(protected ArticleServiceContract $service) {}

    public function index(PreferredArticleIndexRequest $request)
    {
        return ArticleResource::collection(
            $this->service->getPreferredArticles(
                $request->user()->getKey(),
                $request->input('perPage', config('pagination.per_page')),
            )
        );
    }
}
