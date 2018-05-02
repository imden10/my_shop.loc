<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\Categories_feature;
use App\Models\Feature;
use App\Models\Products;
use App\Models\Products_attributes;
use App\Models\Products_categories;
use App\Models\Products_features;
use App\Models\Products_images;
use App\Models\Products_loc;
use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\Languages;
use App\Http\Requests\CreateProduct;
use App\Http\Requests\UpdateProduct;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use Session;
use View;
use Input;

class AdminProductsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /*-----Сортировка-----BEGIN---------------------*/
        $sort = 'products.created_at';
        $order = 'desc';
        if(Input::has('sort')){
            if(Input::get('sort') == 'name'){
                $sort = 'products_loc.'.Input::get('sort');
                $order = Input::get('order');
            }
            else{
                $sort = 'products.'.Input::get('sort');
                $order = Input::get('order');
            }
        }
        /*-----Сортировка-----END-----------------------*/
        if(Input::has('filter_category')){
            $products_ids = Products_categories::where('category_id',Input::get('filter_category'))->lists('product_id')->toArray();
            $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
                ->whereIn('products.id',$products_ids)
                ->where('products_loc.lang', 'ru')
                ->where(function ($query){
                    if(Input::has('filter_name')){
                        $query->Where('products_loc.name','like',"%".Input::get('filter_name')."%");
                    }
                    if(Input::has('filter_vendor')){
                        $query->Where('products.vendor_code','like',"%".Input::get('filter_vendor')."%");
                    }
                    if(Input::has('filter_price')){
                        $query->Where('products.price','=',Input::get('filter_price'));
                    }
                    if(Input::has('filter_count')){
                        $query->Where('products.count','=',Input::get('filter_count'));
                    }
                    if(Input::has('filter_status')){
                        $query->Where('products.status','=',Input::get('filter_status'));
                    }
                })
                ->where('products_images.main','=',1)
                ->leftJoin('products_images','products_images.product_id','=','products.id')
                ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
                ->orderBy($sort,$order)
                ->paginate(15);
        }
        else {
            $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
                ->where('products_loc.lang', 'ru')
                ->where(function ($query){
                    if(Input::has('filter_name')){
                        $query->Where('products_loc.name','like',"%".Input::get('filter_name')."%");
                    }
                    if(Input::has('filter_vendor')){
                        $query->Where('products.vendor_code','like',"%".Input::get('filter_vendor')."%");
                    }
                    if(Input::has('filter_price')){
                        $query->Where('products.price','=',Input::get('filter_price'));
                    }
                    if(Input::has('filter_count')){
                        $query->Where('products.count','=',Input::get('filter_count'));
                    }
                    if(Input::has('filter_status')){
                        $query->Where('products.status','=',Input::get('filter_status'));
                    }
                })
                ->where('products_images.main','=',1)
                ->leftJoin('products_images','products_images.product_id','=','products.id')
                ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
                ->orderBy($sort,$order)
                ->paginate(15);
        }

        $categories = Categories::select(['categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name'])
            ->leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
            ->where('categories_loc.lang', '=', 'ru')
            ->get()->toHierarchy();

//        dd($categories);

        $languages = Languages::select('name','lang as id')->get()->toArray();

        return view('admin.products.show', [
            'products'          => $products,
            'title'             => 'Товары',
            'languages'         => json_encode($languages),
            'categories'        => $categories,
            'markup'            => Settings::find(1)->first()->markup
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createProduct() {
        $categories = Categories::leftJoin('categories_loc','categories_loc.cat_id','=','categories.id')
            ->where('categories_loc.lang','ru')
            ->select('categories.id as id','categories_loc.name','categories.parent_id','categories.lft','categories.rgt','categories.depth')
            ->get()
            ->toHierarchy();

        return view('admin.products.create', [
            'title'         => 'Новый товар',
            'product'       => new Products(),
            'categories'    => $categories,
        ]);
    }

    public function getFeatures(Request $request){
        $ids = $request->ids;
        $variants = [];
        if(isset($request->variants)){
            $variants = json_decode($request->variants,true);
        }

        $features_ids = Categories_feature::whereIn('category_id',$ids)->distinct()->lists('feature_id')->toArray();

        $features = Feature::leftJoin('features_loc','features_loc.feature_id','=','features.id')
                                ->whereIn('features.id',$features_ids)
                                ->where('features_loc.lang','=','ru')
                                ->select('features.id as id','features.parent_id','features_loc.name')
                                ->with('child')
                                ->get();

        return View::make('admin.products.getFeatures',[
            'features'      => $features,
            'variants'      => $variants
        ])->render();
    }

    public function createProductsPost( CreateProduct $request){
        $product = Products::create([
            'slug'              => $request->slug,
            'vendor_code'       => $request->vendor_code,
            'price'             => $request->price,
            'pricesite'         => $request->pricesite,
            'count'             => $request->count,
            'status'            => $request->status,
            'dropshipping'      => $request->dropshipping,
        ]);
        if($product){
            $product_id = $product->id;
            Products_loc::create([
                'product_id'        => $product_id,
                'lang'              => 'ru',
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_description'  => $request->meta_description,
                'meta_keys'         => $request->meta_keys
            ]);
            /*Записываем категории*/
            foreach ($request->categories as $category){
                Products_categories::create([
                    'product_id'     => $product_id,
                    'category_id'    => $category,
                ]);
            }
            /*Записываем изображения*/
            foreach ($request->images as $key => $image){
                Products_images::create([
                    'product_id'     => $product_id,
                    'image'          => $image,
                    'alt'            => $request->images_alt[$key],
                    'main'           => $request->image_main == $image ? 1 : 0
                ]);
            }
            /*Записываем фильтра, если есть*/
            if(isset($request->feature)){
                foreach ($request->feature as $feature){
                    Products_features::create([
                        'product_id'     => $product_id,
                        'feature_id'     => $feature
                    ]);
                }
            }
            /*Записываем атрибуты, если есть*/
            if(isset($request->attribute_name)){
                foreach ($request->attribute_name as $key => $attr){
                    Products_attributes::create([
                        'product_id'     => $product_id,
                        'lang'           => 'ru',
                        'name'           => $attr,
                        'value'          => $request->attribute_value[$key],
                    ]);
                }
            }
            return redirect('/master/products')->with('success','Товар успешно добавлен!');
        }
        else {
            return redirect()->back()->with('error','Ошибка записи!');

        }
    }

    public function editProduct($id){
        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $flag = Products_loc::whereLang($lang)->where('product_id', $id)->first();
        if(!$flag){
            $lang = 'ru';
        }

        $product = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
            ->where('products_loc.lang', $lang)
            ->where('products.id', $id)
            ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_loc.meta_title','products_loc.meta_description','products_loc.meta_keys')
            ->first();

        $categories = Categories::leftJoin('categories_loc','categories_loc.cat_id','=','categories.id')
            ->where('categories_loc.lang','ru')
            ->select('categories.id as id','categories_loc.name','categories.parent_id','categories.lft','categories.rgt','categories.depth')
            ->get()
            ->toHierarchy();

//        dd($categories);

        $categories_ids = Products_categories::where('product_id',$id)->lists('category_id')->toArray();

        $languages = Languages::select('name','lang as id')->get()->toArray();

        $features_ids = Products_features::where('product_id',$id)->lists('feature_id')->toArray();

        $attributes = Products_attributes::where('product_id',$id)->where('lang',$lang)->get();

        $images = Products_images::where('product_id',$id)->orderBy('main','DESK')->get();

        return view('admin.products.edit', [
            'title'             => 'Редактировать продукт',
            'product'           => $product,
            'categories'        => $categories,
            'categories_ids'    => $categories_ids,
            'languages'         => json_encode($languages),
            'features_ids'      => json_encode($features_ids),
            'attributes'        => $attributes,
            'images'            => $images
        ] );
    }

    public function get_lang_products_edit(Request $request){

        Session::put('alang',$request->lang);

        $flag = Products_loc::whereLang($request->lang)->where('product_id', $request->id)->first();
        if(!$flag){
            $lang = 'ru';
        }
        else {
            $lang = $flag->lang;
        }

        $product = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
            ->where('products_loc.lang', $lang)
            ->where('products.id', $request->id)
            ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_loc.meta_title','products_loc.meta_description','products_loc.meta_keys')
            ->first();

        $attr = Products_attributes::where('product_id',$request->id)->where('lang',$request->lang)->get();

        $res = [
            'product'   => $product,
            'attr'      => $attr,
        ];

        return json_encode($res);
    }

    public function updateProductsPost(UpdateProduct $request){
//        dd($request->all());
        $status = $request->has('status') ? '1' : '0';
        $product = Products::whereId($request->id)->update([
            'vendor_code'       => $request->vendor_code,
            'price'             => $request->price,
            'pricesite'         => $request->pricesite,
            'count'             => $request->count,
            'status'            => $status,
            'dropshipping'      => $request->dropshipping,
        ]);

        if($request->has('slug')){
            Products::whereId($request->id)->update([
                'slug'    => $request->slug
            ]);
        }

        /*Категории*/
        Products_categories::where('product_id',$request->id)->delete();
        foreach ($request->categories as $category){
            Products_categories::create([
                'product_id'     => $request->id,
                'category_id'    => $category,
            ]);
        }

        /*Фильтры*/
        Products_features::where('product_id',$request->id)->delete();
        if($request->has('feature')){/*если есть фильтра*/
            foreach ($request->feature as $feature){
                Products_features::create([
                    'product_id'     => $request->id,
                    'feature_id'     => $feature
                ]);
            }
        }

        /*Аттрибуты*/
        Products_attributes::where('product_id',$request->id)->where('lang',$request->lang)->delete();
        if(isset($request->attribute_name)){
            foreach ($request->attribute_name as $key => $attr){
                Products_attributes::create([
                    'product_id'     => $request->id,
                    'lang'           => $request->lang,
                    'name'           => $attr,
                    'value'          => $request->attribute_value[$key],
                ]);
            }
        }

        /*Записываем изображения*/
        Products_images::where('product_id',$request->id)->delete();
        foreach ($request->images as $key => $image){
            Products_images::create([
                'product_id'     => $request->id,
                'image'          => $image,
                'alt'            => $request->images_alt[$key],
                'main'           => $request->image_main == $image ? 1 : 0
            ]);
        }

        if($request->make == 'create'){/*Сохранение продукта на новом языку*/
            $name_lang = Languages::whereLang($request->lang)->first()->name;
            $success = 'Создана копия продукта на языку: '.$name_lang.'!';
            Products_loc::create([
                'product_id'        => $request->id,
                'lang'              => $request->lang,
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_keys'         => $request->meta_keys,
                'meta_description'  => $request->meta_description
            ]);
        }
        elseif($request->make == 'update'){/*Обновление на текущем языку*/
            $success = 'Продукт успешно обновлен!';
            Products_loc::where('product_id',$request->id)->where('lang',$request->lang)->update([
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_keys'         => $request->meta_keys,
                'meta_description'  => $request->meta_description
            ]);
        }
        return redirect()->back()->with('success',$success);
    }

    public function delete(Request $request){
//        dd($request->all());
        $checked = $request->checked;
        if(count($checked) > 0){
            Products::whereIn('id',$checked)->delete();

            $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
                ->where('products_loc.lang', 'ru')
                ->where('products_images.main','=',1)
                ->leftJoin('products_images','products_images.product_id','=','products.id')
                ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
                ->orderBy('products.created_at','DESC')
                ->paginate(15);

            $res = [
                'status'            => true,
                'products'          => $products->all(),
            ];
            return json_encode($res);
        }
    }
}
