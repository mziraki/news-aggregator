<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\PreferredArticleIndexRequest;
use App\Http\Resources\ArticleResource;
use App\Repositories\Contracts\ArticleRepositoryInterface;

class PreferredArticleController extends Controller
{
    public function __construct(protected ArticleRepositoryInterface $articles) {}

    public function index(PreferredArticleIndexRequest $request)
    {
        return ArticleResource::collection(
            $this->articles->getPreferredForUser(
                $request->user()->id,
                $request->input('perPage', config('pagination.per_page'))
            )
        );
    }
}
