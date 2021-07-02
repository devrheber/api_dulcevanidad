<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\ShoppingCart;
use App\Models\ShoppingCartDetail;
use App\Models\SubCategory;
use App\Models\Ubigeo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class CatalogController extends Controller
{
    public function index() {
        $data = array(
            'sub_categories' => SubCategory::where('state', 1)->get(),
            'articles' => Article::where('state', 1)->get()
        );
        return view('catalog.index')->with($data);
    }

    public function saveCustomer(Request $request) {
        $customer = new Customer;
        $customer->name = $request->post('name');
        $customer->surnames = $request->post('surnames');
        $customer->phone = $request->post('phone');
        $customer->email = $request->post('email');
        $customer->save();

        $sale = Sale::find($request->post('sale_id'));
        $sale->customer_id = $customer->id;
        $sale->save();

        return response()->json(true);
    }

    public function checkDelivery(Request $request) {
        $sale = Sale::find($request->post('sale_id'));
        $sale->type_delivery = $request->post('type');
        $sale->save();
        return response()->json(true);
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

    public function getCategories() {
        return response()->json(Category::where('state', 1)->get());
    }

    public function getSubCategories() {
        return response()->json(SubCategory::where('state', 1)->get());
    }

    public function getCatalogArticles() {
        return response()->json(Article::where('state', 1)->with('images')->get());
    }

    public function getPaymentMethod() {
        return response()->json(Bank::with('payment_methods')->get());
    }

    public function checkShoppingCart(Request $request) {
        $requestShoppingCart = $request->post('shoppingCart');
        DB::beginTransaction();
        try {
            $shoppingCart = new ShoppingCart;
            $shoppingCart->url = 'venta_' . uniqid();
            $shoppingCart->state = 2;
            $shoppingCart->voucher = '0';
            $shoppingCart->payment_method_id = $request->post('payment_method');
            $shoppingCart->total = $request->post('total');
            $shoppingCart->save();
            for($x = 0; $x < count($requestShoppingCart); $x++) {
                $article = Article::find($requestShoppingCart[$x]['id']);
                if ($article) {
                    if ($article->quantity < $requestShoppingCart[$x]['quantity']) {
                        return response()->json('El producto ' . $article->name . ' no cuenta con stock suficiente.');
                    } else {
                        $article->update(['quantity' => $article->quantity - $requestShoppingCart[$x]['quantity']]);
                        $shoppingCartDetail = new ShoppingCartDetail;
                        $shoppingCartDetail->shopping_cart_id = $shoppingCart->id;
                        $shoppingCartDetail->article_id = $requestShoppingCart[$x]['id'];
                        $shoppingCartDetail->price = $requestShoppingCart[$x]['price'];
                        $shoppingCartDetail->quantity = $requestShoppingCart[$x]['quantity'];
                        $shoppingCartDetail->save();
                    }
                } else {
                    return response()->json('No tenemos existencias de uno de los productos seleccionados');
                }
            }

            DB::commit();

            return response()->json(array(
                'response' => true,
                'data' => array(
                    'created_at' => $shoppingCart->created_at,
                    'operation' => $shoppingCart->url
                )
            ));
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json($e->getMessage());
            return response()->json(array(
                'response' => false,
                'data' => null
            ));
        }
    }

    public function completePayment(Request $request) {
        DB::beginTransaction();
        try {
            $shoppingCart = ShoppingCart::where('url', $request->post('operation'))->first();
            $shoppingCart->code = $request->post('code');
            $file_url = Storage::disk('public')->put('vouchers', $request->file('voucher'), 'public');
            $shoppingCart->voucher = Storage::disk('public')->url($file_url);
            $shoppingCart->state = 1;
            $shoppingCart->save();

            $sale = new Sale;
            $sale->url = $shoppingCart->url;
            $sale->state = 1;
            $sale->code = $shoppingCart->code;
            $sale->voucher = $shoppingCart->voucher;
            $sale->payment_method_id = $shoppingCart->payment_method_id;
            $sale->customer_id = $shoppingCart->customer_id;
            $sale->shopping_cart_id = $shoppingCart->id;
            $sale->total = $shoppingCart->total;
            $sale->save();


            // $shoppingCart = ShoppingCart::find($shoppingCart->id);
            for($x = 0; $x < count($shoppingCart->shoppingCartDetail); $x++) {

                $sale_detail = new SaleDetail;
                $sale_detail->sale_id = $sale->id;
                $sale_detail->article_id = $shoppingCart->shoppingCartDetail[$x]->article_id;
                $sale_detail->price = $shoppingCart->shoppingCartDetail[$x]->price;
                $sale_detail->quantity = $shoppingCart->shoppingCartDetail[$x]->quantity;
                $sale_detail->save();
            }
            DB::commit();

            return response()->json(array(
                'response' => true,
                'sale' => $sale->id
            ));
        } catch (Exception $e) {
            DB::rollBack();
            // return response()->json($e->getMessage());
            return response()->json(array(
                'response' => false,
                'sale' => null
            ));
        }
    }

    public function getUbigeo($province, $search = '') {
        if ($province !== 'LIMA') {
            return response()->json(
                Ubigeo::where([
                    ['department', '!=', 'LIMA'],
                    ['province', 'like', '%' . $search . '%']
                ])->select('province')->distinct()->get('province')->take('15')
            );
        } else {
            return response()->json(
                Ubigeo::where([
                    ['department', $province],
                    ['province', 'like', '%' . $search . '%']
                ])->select('province')->distinct()->get('province')->take('15')
            );
        }
    }
}
