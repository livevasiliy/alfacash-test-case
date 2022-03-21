<?php

declare(strict_types=1);

namespace App\NewsApi;

use GuzzleHttp\Client;
use GuzzleHttp\Promise;
use GuzzleHttp\Psr7\Response;
use Webmozart\Assert\Assert as WebmozartAssert;
use function Safe\json_decode;

class NewsApiClient
{
    public const ENDPOINT = 'https://newsapi.org/v2/everything';

    private const LIMIT_REQUEST_POST = 1;

    public function __construct(private Client $httpClient)
    {
        $this->httpClient = new Client([
            'headers' => [
                'Accept' => 'application/json',
                'X-Api-Key' => config('news_api.secret'),
            ],
        ]);
    }

    public function getPosts(): array
    {
        $posts = [];

        foreach (config('parser.keywords') as $keyword) {
            $promises[$keyword] = $this->httpClient->getAsync(self::ENDPOINT, [
                'query' => [
                    'q' => sprintf('+%s', $keyword),
                    'pageSize' => self::LIMIT_REQUEST_POST
                ],
            ]);

            /** @var Response[] $responses */
            $responses = Promise\Utils::unwrap($promises);

            $post = json_decode((string)$responses[$keyword]->getBody(), true);

            WebmozartAssert::keyExists(
                $post, 'articles',
                sprintf('Failed to fetched articles by keyword %s.', $keyword)
            );

            WebmozartAssert::count(
                $post['articles'], self::LIMIT_REQUEST_POST,
                sprintf('Empty array articles by keyword %s.', $keyword));

            // Always extract first fetched posts.
            $posts[$keyword] = $post['articles'][0];
        }

        WebmozartAssert::notEmpty($posts, 'Failed fetch articles');

        return $posts;
    }
}
