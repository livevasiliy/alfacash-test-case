<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\NewsSource;
use App\NewsApi\NewsApiClient;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Webmozart\Assert\Assert as WebmozartAssert;
use App\Models\News;

class ParseLatestNews extends Job
{
    private NewsApiClient $newsApi;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(private Client $httpClient)
    {
        $this->newsApi = new NewsApiClient($this->httpClient);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $keywords = config('parser.keywords');
        WebmozartAssert::notEmpty($keywords, 'List of keywords must filled.');
    }
}
