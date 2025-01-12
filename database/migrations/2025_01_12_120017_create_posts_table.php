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
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // Auto-incremental
            $table->string('title'); // Título do post
            $table->text('content'); // Conteúdo do post
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Relacionamento com o usuário (foreign key)
            $table->timestamps(); // Campos created_at e updated_at
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('posts');
    }
    
};
