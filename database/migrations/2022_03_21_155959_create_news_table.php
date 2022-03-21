<?php

use App\Models\NewsSource;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('author')->nullable();
            $table->string('title');
            $table->mediumText('description');
            $table->string('url');
            $table->string('urlToImage');
            $table->dateTimeTz('publishedAt');
            $table->longText('content');
            $table->foreignIdFor(NewsSource::class);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
};
