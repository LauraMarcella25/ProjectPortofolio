<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('image');
            $table->timestamps();
        });

        Schema::create('activity_photos', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image');
            $table->timestamps();
        });

        if (!Schema::hasColumn('projects', 'demo_video')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->string('demo_video')->nullable()->after('image');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('certificates');
        Schema::dropIfExists('activity_photos');

        if (Schema::hasColumn('projects', 'demo_video')) {
            Schema::table('projects', function (Blueprint $table) {
                $table->dropColumn('demo_video');
            });
        }
    }
};
