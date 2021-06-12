<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index() {
        $data = array(
            'sub_categories' => SubCategory::where('state', 1)->get(),
            'articles' => Article::where('state', 1)->get()
        );
        return view('catalog.index')->with($data);
    }

    public function shop() {
        return view('catalog.shop');
    }

    public function from() {
        return view('catalog.from');
    }

    public function pay() {
        return view('catalog.pay');
    }

    public function getCatalogArticles() {
        return response()->json(Article::where('state', 1)->get());
    }
}
