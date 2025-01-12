<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('post_tag', function (Blueprint $table) {
            $table->id();
            $table->foreignId('post_id')->constrained()->onDelete('cascade'); // Relacionamento com posts
            $table->foreignId('tag_id')->constrained()->onDelete('cascade'); // Relacionamento com tags
            $table->timestamps(); // Campos created_at e updated_at
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('post_tag');
    }
};
