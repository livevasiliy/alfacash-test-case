<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class News extends Model
{
    protected $table = 'news';

    public $timestamps = false;

    protected $fillable = [
        'author',
        'title',
        'description',
        'url',
        'urlToImage',
        'publishedAt',
        'content'
    ];

    protected $dates = [
        'publishedAt'
    ];

    public function newsSource(): BelongsTo
    {
        return $this->BelongsTo(NewsSource::class);
    }
}
