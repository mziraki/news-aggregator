<?php

namespace App\Services\Contracts;

use App\Dtos\ArticleDto;

interface NewsProviderServiceContract
{
    /**
     * @return array<ArticleDto>
     */
    public function fetch(?string $query = null): array;
}
