<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('uuid')->nullable()->unique()->after('id');
            $table->jsonb('name_jsonb')->nullable()->after('name');
            $table->string('gender')->nullable();
            $table->jsonb('location')->nullable();
            $table->integer('age')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(
                'uuid',
                'gender',
                'name_jsonb',
                'location',
                'age',
            );
        });
    }
};
