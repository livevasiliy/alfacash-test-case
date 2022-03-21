<?php

declare(strict_types=1);

namespace App\News;

use App\Models\NewsSource;
use App\NewsApi\NewsApiClient;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Webmozart\Assert\Assert as WebmozartAssert;

class NewsParser
{
    public function __construct(private Client $httpClient)
    {
    }

    public function parse(): void
    {
        // Fetch posts
        $posts = (new NewsApiClient($this->httpClient))->getPosts();

        // Check on unique post in database
        foreach ($posts as $theme => $post) {
            $source = self::fetchNewsSource($post);
            if ($source === null) {
                $source = new NewsSource([
                    'name' => $post['source']['name'],
                ]);
                $source->save();
            }

            if (self::fetchNews($post) === null) {
                $source->news()->create([
                    'author' => $post['author'],
                    'title' => $post['title'],
                    'description' => $post['description'],
                    'url' => $post['url'],
                    'urlToImage' => $post['urlToImage'],
                    'publishedAt' => $post['publishedAt'],
                    'content' => $post['content'],
                ]);
            }
        }
    }

    private function fetchNewsSource(array $post): ?NewsSource
    {
        WebmozartAssert::keyExists($post, 'source', 'Cannot extract news source');
        WebmozartAssert::keyExists($post['source'], 'name', 'Cannot extract name source news');

        return NewsSource::where('name', '=', $post['source']['name'])->first();
    }

    private function fetchNews(array $post): ?NewsSource
    {
        WebmozartAssert::keyExists($post, 'title', 'Cannot extract title from post');

        return self::fetchNewsSource($post)->whereHas('news', function (Builder $query) use ($post) {
            $query->where('title', '=', $post['title']);
        })->first();
    }
}
