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
        Schema::create('destinations', function (Blueprint $table) {
            $table->id();
            $table->string('host');
            $table->string('port');
            $table->string('database');
            $table->string('user');
            $table->string('password');
            $table->string('table_name');
            $table->boolean('enable')->default(false)->comment('information if destination are enable or not');
            $table->string('if_exists')->default('append')->comment('
                exists two types when table exists in pandas: append data ou replace data
            ');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('destinations');
    }
};
