<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Article extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $appends = ['abbreviated_content'];

    protected $fillable = ['title', 'content', 'article_category_id'];

    public function article_category(){
        return $this->belongsTo(ArticleCategory::class);
    }

    public function getAbbreviatedContentAttribute(){
        return substr(strip_tags($this->content), 0, 80);
    }
}
