<?php

namespace App\Domain\Tag\Entities;

use App\Domain\Post\Entities\Post; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Database\Factories\TagFactory; 

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];


    protected static function newFactory(): TagFactory
    {
        return TagFactory::new();
    }

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }
}
