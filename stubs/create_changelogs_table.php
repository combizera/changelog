<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('changelogs', function (Blueprint $table) {
            $table->id();
            $table->string('version');
            $table->date('release_date');
            $table->enum('type', ['new', 'improvement', 'fix', 'security', 'deprecated']);
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_published')->default(true);

            $table->index(['is_published', 'release_date']);
            $table->index('version');
            $table->index('type');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('changelogs');
    }
};
