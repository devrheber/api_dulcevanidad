<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = ['description', 'state', 'abbreviation'];

    public function payment_methods() {
        return $this->hasMany(PaymentMethod::class);
    }
}
