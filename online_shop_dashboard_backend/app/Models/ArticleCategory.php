<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Kalnoy\Nestedset\NodeTrait;

class ArticleCategory extends Model
{
    use HasFactory;
    use SoftDeletes;
    use NodeTrait;

    protected $fillable = ['name', 'parent_id', 'description'];

    public function articles(){
        return $this->hasMany(Article::class);
    }
}
