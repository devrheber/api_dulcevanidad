<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\ShoppingCart;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function sales() {
        return view('transaction.sales');
    }

    public function dtSales() {
        return datatables()->of(Sale::with('customer', 'payment_method.bank')->get())->toJson();
    }

    public function operations() {
        return view('transaction.operations');
    }

    public function dtOperations() {
        return datatables()->of(ShoppingCart::with('sale')->get())->toJson();
    }
}
