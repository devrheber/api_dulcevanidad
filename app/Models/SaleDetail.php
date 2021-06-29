<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    public function article() {
        return $this->belongsTo(Article::class);
    }

    public function sale() {
        return $this->hasOne(Sale::class);
    }
}
