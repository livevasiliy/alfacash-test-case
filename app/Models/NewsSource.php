<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NewsSource extends Model
{
    protected $table = 'news_sources';

    public $timestamps = false;

    protected $fillable = [
        'name'
    ];

    public function news(): HasMany
    {
        return $this->hasMany(News::class);
    }
}
