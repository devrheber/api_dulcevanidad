<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleImage;
use App\Models\Category;
use App\Models\SubCategory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ConfigurationController extends Controller
{
    public function categories() {
        return view('configuration.categories');
    }

    public function dtCategory() {
        return datatables()->of(Category::where('state', 1)->get())->toJson();
    }

    public function saveCategory(Request $request) {
        if ($request->post('id') !== null) {
            $category = Category::find($request->post('id'));
        } else {
            $category = new Category;
        }

        $category->description = $request->post('description');
        $category->state = $request->post('state');
        return response()->json($category->save());
    }

    public function sub_categories() {
        $data = array(
            'categories'    => Category::where('state', 1)->get()
        );
        return view('configuration.sub_categories')->with($data);
    }

    public function dtSubCategory() {
        return datatables()->of(SubCategory::where('state', 1)->with('category')->get())->toJson();
    }

    public function saveSubCategory(Request $request) {
        if ($request->post('id') !== null) {
            $sub_category = SubCategory::find($request->post('id'));
        } else {
            $sub_category = new SubCategory;
        }

        $sub_category->description = $request->post('description');
        $sub_category->state = $request->post('state');
        $sub_category->category_id = $request->post('category');
        return response()->json($sub_category->save());
    }

    public function articles() {
        $data = array(
            'sub_categories'    => SubCategory::where('state', 1)->get()
        );
        return view('configuration.articles')->with($data);
    }

    public function dtArticle() {
        return datatables()->of(Article::where('state', 1)->with('sub_category', 'images')->get())->toJson();
    }

    public function saveArticle(Request $request) {
        try {
            DB::beginTransaction();
            if ($request->post('id') !== null) {
                $article = Article::find($request->post('id'));
                $imageUrl = $article->image;
            } else {
                $imageUrl = 'articles/default.png';
                $article = new Article;
            }

            $article->name = $request->post('name');
            $article->state = $request->post('state');
            $article->sub_category_id = $request->post('sub_category');
            $article->quantity = $request->post('quantity');
            $article->price1 = $request->post('price1');
            $article->price2 = $request->post('price2') ? $request->post('price2') : 0;
            $article->price3 = $request->post('price3') ? $request->post('price3') : 0;
            $article->detail = $request->post('detail');
            $article->image = $imageUrl;
            $article->save();

            if ($request->file('images') !== null) {
                for ($x = 0; $x < count($request->file('images')); $x++) {
                    $image = new ArticleImage;
                    $image->url = Storage::disk('public')->put('articles', $request->file('images')[$x], 'public');
                    $image->article_id = $article->id;
                    $image->save();
                }
            }

            DB::commit();

            return response()->json(true);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(false);
        }
    }

    public function updateDiscount(Request $request) {
        $article = Article::find($request->post('id'));
        $article->stateDiscount = 1;
        return response()->json($article->save());
    }

    public function deleteImage(Request $request) {
        $image = ArticleImage::find($request->post('id'));
        Storage::delete($image->url);
        return response()->json($image->delete());
    }
}
