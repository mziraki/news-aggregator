<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'body' => $this->body,
            'url' => $this->url,
            'image_url' => $this->image_url,
            'published_at' => $this->published_at,
            'author' => $this->author,
            'source' => [
                'id' => $this->source->id,
                'name' => $this->source->name,
                'key' => $this->source->key,
            ],
            'categories' => $this->categories->map(fn ($c) => ['id' => $c->id, 'name' => $c->name, 'slug' => $c->slug]),
        ];
    }
}
