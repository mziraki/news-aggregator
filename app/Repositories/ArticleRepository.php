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
        $query = Article::query()->with(['source', 'categories']);

        if (! empty($filters['q'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', '%'.$filters['q'].'%')
                    ->orWhere('summary', 'like', '%'.$filters['q'].'%')
                    ->orWhere('body', 'like', '%'.$filters['q'].'%');
            });
        }

        if (! empty($filters['from'])) {
            $query->where('published_at', '>=', $filters['from']);
        }

        if (! empty($filters['to'])) {
            $query->where('published_at', '<=', $filters['to']);
        }

        if (! empty($filters['source'])) {
            $query->whereHas('source', fn ($q) => $q->where('key', $filters['source']));
        }

        if (! empty($filters['category'])) {
            $query->whereHas('categories', fn ($q) => $q->where('slug', $filters['category']));
        }

        if (! empty($filters['author'])) {
            $query->where('author', 'like', '%'.$filters['author'].'%');
        }

        return $query->orderBy('published_at', 'desc')->paginate($filters['perPage'] ?? null);
    }

    public function getPreferredForUser(int $userId, int $perPage): LengthAwarePaginator
    {
        $user = User::findOrFail($userId);

        $query = Article::query()->with(['source', 'categories']);

        if (! empty($user->preferred_sources)) {
            $query->whereHas('source', fn ($q) => $q->whereIn('key', $user->preferred_sources));
        }

        if (! empty($user->preferred_categories)) {
            $query->whereHas('categories', fn ($q) => $q->whereIn('slug', $user->preferred_categories));
        }

        if (! empty($user->preferred_authors)) {
            $query->whereIn('author', $user->preferred_authors);
        }

        return $query->orderBy('published_at', 'desc')->paginate($perPage);
    }
}
