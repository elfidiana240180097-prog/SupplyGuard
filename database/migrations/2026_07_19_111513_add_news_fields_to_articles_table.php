<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->foreignId('country_id')
                ->nullable()
                ->after('id');

            $table->string('source')
                ->nullable()
                ->after('title');

            $table->string('author')
                ->nullable()
                ->after('source');

            $table->text('description')
                ->nullable()
                ->after('summary');

            $table->string('url')
                ->nullable()
                ->after('image');

            $table->timestamp('published_at')
                ->nullable()
                ->after('status');

        });
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {

            $table->dropColumn([
                'country_id',
                'source',
                'author',
                'description',
                'url',
                'published_at'
            ]);

        });
    }
};