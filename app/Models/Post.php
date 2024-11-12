<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content',
        'user_id'
    ];

    // Função que define o relacionamento de um post com um usuário. 
    // Cada post pertence a um usuário, e esse relacionamento é feito através da chave estrangeira 'user_id'.
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Função que define o relacionamento de um post com um usuário. 
    // Cada post pertence a um usuário, e esse relacionamento é feito através da chave estrangeira 'user_id'.
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    // Função que buscam os dados de postagem 
    public static function getdata()
    {
        $posts = Post::select('posts.id', 'posts.title', 'posts.content', 'posts.created_at', 'users.name as user_name')
            ->join('users', 'posts.user_id', '=', 'users.id')
            ->join('post_tag', 'posts.id', '=', 'post_tag.post_id')
            ->join('tags', 'post_tag.tag_id', '=', 'tags.id')
            ->selectRaw('string_agg(tags.name, \', \') as tag_names')
            ->groupBy('posts.id', 'posts.title', 'posts.content', 'posts.created_at', 'users.name')
            ->get();

        return $posts;
    }
}
