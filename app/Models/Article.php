<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = ['quantity'];

    public function sub_category() {
        return $this->belongsTo(SubCategory::class);
    }

    public function images() {
        return $this->hasMany(ArticleImage::class);
    }
}
