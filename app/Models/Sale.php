<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    public function customer() {
        return $this->belongsTo(Customer::class);
    }

    public function sale_detail() {
        return $this->hasMany(SaleDetail::class);
    }

    public function payment_method() {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function shopping_cart() {
        return $this->belongsTo(ShoppingCart::class);
    }
}
