<?php

use App\Dtos\ArticleDto;

it('creates an ArticleDto with correct properties', function () {
    $data = [
        'external_id' => 'guardian-123',
        'title' => 'Breaking News Title',
        'summary' => 'Short summary here',
        'body' => 'Full article body content.',
        'url' => 'https://example.com/article',
        'image_url' => 'https://example.com/image.jpg',
        'published_at' => '2025-10-05T12:00:00Z',
        'author' => 'John Doe',
        'categories' => ['world', 'politics'],
        'source_key' => 'guardian',
        'raw' => ['raw_data' => 'something'],
    ];

    $dto = new ArticleDto(...$data);

    expect($dto)
        ->external_id->toBe($data['external_id'])
        ->title->toBe($data['title'])
        ->summary->toBe($data['summary'])
        ->body->toBe($data['body'])
        ->url->toBe($data['url'])
        ->image_url->toBe($data['image_url'])
        ->published_at->toBe($data['published_at'])
        ->author->toBe($data['author'])
        ->categories->toBe($data['categories'])
        ->source_key->toBe($data['source_key'])
        ->raw->toBe($data['raw']);
});

it('returns correct array representation', function () {
    $dto = new ArticleDto(
        external_id: 'id-999',
        title: 'Test Article',
        summary: 'Summary text',
        body: 'Body text',
        url: 'https://example.com/article',
        image_url: null,
        published_at: '2025-10-05',
        author: 'Jane Doe',
        categories: ['tech'],
        source_key: 'guardian',
        raw: ['foo' => 'bar'],
    );

    $array = $dto->toArray();

    expect($array)->toMatchArray([
        'external_id' => 'id-999',
        'title' => 'Test Article',
        'summary' => 'Summary text',
        'body' => 'Body text',
        'url' => 'https://example.com/article',
        'image_url' => null,
        'published_at' => '2025-10-05',
        'author' => 'Jane Doe',
        'categories' => ['tech'],
        'source_key' => 'guardian',
        'raw' => ['foo' => 'bar'],
    ]);
});

it('is immutable after creation', function () {
    $dto = new ArticleDto(
        external_id: 'id-1',
        title: 'Immutable Test',
        summary: 'Summary',
        body: 'Body',
        url: 'https://example.com',
        image_url: null,
        published_at: null,
        author: null,
        categories: [],
        source_key: 'guardian',
    );

    expect(fn () => $dto->title = 'Changed')->toThrow(Error::class);
});
