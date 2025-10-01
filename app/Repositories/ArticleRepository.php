<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\User;
use App\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ArticleRepository implements ArticleRepositoryInterface
{
    public function search(array $filters = []): LengthAwarePaginator
    {
        return Article::query()
            ->with(['source', 'categories'])
            ->unless(empty($filters['q']), fn ($query) => $query->where(fn ($q) => $q
                ->where('title', 'like', '%'.$filters['q'].'%')
                ->orWhere('summary', 'like', '%'.$filters['q'].'%')
                ->orWhere('body', 'like', '%'.$filters['q'].'%')
            ))
            ->unless(empty($filters['from']), fn ($query) => $query->where('published_at', '>=', $filters['from']))
            ->unless(empty($filters['to']), fn ($query) => $query->where('published_at', '<=', $filters['to']))
            ->unless(empty($filters['source']), fn ($query) => $query->whereHas('source', fn ($q) => $q->where('key', $filters['source'])))
            ->unless(empty($filters['category']), fn ($query) => $query->whereHas('categories', fn ($q) => $q->where('slug', $filters['category'])))
            ->unless(empty($filters['author']), fn ($query) => $query->where('author', 'like', '%'.$filters['author'].'%'))
            ->orderBy('published_at', 'desc')
            ->paginate($filters['perPage'] ?? null);
    }

    public function getPreferredForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        $user = User::findOrFail($userId);

        return Article::query()
            ->with(['source', 'categories'])
            ->unless(empty($user->preferred_sources), fn ($query) => $query->whereHas('source', fn ($q) => $q->whereIn('key', $user->preferred_sources)))
            ->unless(empty($user->preferred_categories), fn ($query) => $query->whereHas('categories', fn ($q) => $q->whereIn('slug', $user->preferred_categories)))
            ->unless(empty($user->preferred_authors), fn ($query) => $query->whereIn('author', $user->preferred_authors))
            ->orderBy('published_at', 'desc')
            ->paginate($perPage);
    }
}
