<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    /** @use HasFactory<\Database\Factories\ArticleFactory> */
    use HasFactory;

    protected $casts = [
        'published_at' => 'datetime',
        'raw_json' => 'array',
    ];

    public function source()
    {
        return $this->belongsTo(Source::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class);
    }
}
