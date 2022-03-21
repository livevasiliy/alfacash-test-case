<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\News\NewsParser;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class ParseNewsCommand extends Command
{
    private NewsParser $parser;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:parse:news';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Parse news from newsapi.org source.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(private Client $httpClient)
    {
        parent::__construct();

        $this->parser = new NewsParser($this->httpClient);
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        try {
            $this->info('Starting parsing...');
            $this->parser->parse();

            $this->info('Finished parsing');

            return Command::SUCCESS;
        } catch (Exception $e) {
            Log::error($e->getMessage(), $e->getTrace());
            $this->error('Something went wrong, check generated log file');
            return Command::FAILURE;
        }
    }
}
