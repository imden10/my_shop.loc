<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Products;
use Illuminate\Http\Request;
use App\User;
use App\Models\Categories;
use View;
use App\Http\Requests;
use App\Http\Controllers\Frontend\BaseController;

class MoreContentController extends BaseController
{

    public function getProduct(Request $request)
    {
        $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
            ->where('products_loc.lang', 'ru')
            ->where('products_images.main','=',1)
            ->leftJoin('products_images','products_images.product_id','=','products.id')
            ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
            ->take($request->count_more)
            ->skip($request->skip)
            ->get();
        $res = View::make('more/product', [
            'products'     => $products,
        ])->render();
        $result = [
            'res' => $res,
            'more' => count($products)
        ];
        return json_encode($result);
    }
}
