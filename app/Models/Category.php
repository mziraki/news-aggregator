<?php

namespace App\Models;

use Database\Factories\CategoryFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

#[UseFactory(CategoryFactory::class)]
class Category extends Model
{
    use HasFactory;

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
}
