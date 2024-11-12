<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostTag extends Model
{
    // Definindo que o modelo representa a tabela intermediária 'post_tag'
    protected $table = 'post_tag';

    // Como estamos usando um relacionamento many-to-many, a chave primária 'id' não é necessária para o modelo
    public $incrementing = false;
    protected $primaryKey = null;

    // A tabela post_tag possui timestamps (created_at, updated_at), então podemos definir isso
    public $timestamps = true;

    // Campos que podem ser preenchidos em massa (mass assignable)
    protected $fillable = ['post_id', 'tag_id'];
}