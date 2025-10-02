<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferredArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Services\ArticleService;

class PreferredArticleController extends Controller
{
    public function __construct(protected ArticleService $service) {}

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
