<?php

namespace App\Models\Content;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;
    protected $table = 'content.article';
    protected $keyType = 'string';
    public $incrementing = true;

    protected $fillable = [
        'title',
        'desc',
        'image',
        'created_at',
        'updated_at',
    ];
}
