<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (!Schema::hasColumn('projects', 'video_file')) {
                $table->string('video_file')->nullable();
            }
            if (!Schema::hasColumn('projects', 'pdf_file')) {
                $table->string('pdf_file')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (Schema::hasColumn('projects', 'video_file')) {
                $table->dropColumn('video_file');
            }
            if (Schema::hasColumn('projects', 'pdf_file')) {
                $table->dropColumn('pdf_file');
            }
        });
    }
};
