<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Feature;
use App\Models\Categories;
use App\Models\Products_features;
use App\Models\Products_categories;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Page;
use App;
use App\Models\Products;
use Session;
use Input;

class CatalogController extends BaseController
{

    private  function getProductsIdsByFeaturesIds($checked){
        $filters_features_ids = $checked;
        $products_features_ids = Products_features::whereIn('feature_id',$filters_features_ids)->lists('product_id')->toArray();
        $products_features_ids = array_count_values($products_features_ids);
        $products_features_ids = collect($products_features_ids);
        $products_features_ids = $products_features_ids->filter(function ($item) use($checked){
            return $item == count($checked);
        });
        return $products_features_ids->keys()->toArray();
    }

    public function index(Request $request, $page_url = null)
    {
        $lang = App::getLocale();

        /*-----Сортировка-----BEGIN---------------------*/
        $sort = 'products.created_at';
        $order = 'desc';
        if(Input::has('sort')){
            switch (Input::get('sort')){
                case 'price_asc':$sort='products.pricesite';$order='asc';break;
                case 'price_desc':$sort='products.pricesite';$order='desc';break;
                case 'name_asc':$sort='products_loc.name';$order='asc';break;
                case 'name_desc':$sort='products_loc.name';$order='desc';break;
                case 'all':$sort='products.created_at';$order='desc';break;
            }
        }
        /*-----Сортировка-----END-----------------------*/

        /*Пагинация*/
        if (Session::has('paginate_count')) {
            $paginate_count = Session::get('paginate_count');
        } else {
            $paginate_count = 9; /*По умолчанию*/
        }
        if ($request->isMethod('post')) {
            $paginate_count = $request->paginate_count;
            Session::put('paginate_count', $paginate_count);
        }
        /*Пагинация*/

        $page = Page::whereSlug('/')->first();

        /*отображение товаров list/grid*/
        if(!Session::has('view'))
            Session::put('view','grid');/*По умолчанию*/

        $categories = Categories::select(['categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name'])
            ->leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
            ->where('categories_loc.lang', $lang)
            ->get()->toHierarchy();

        if($page_url){  /*какая то категория*/

            $products_ids_by_features = [];
            if($request->checked){
                $products_ids_by_features = self::getProductsIdsByFeaturesIds($request->checked);
            }

            $current_category = Categories::whereSlug($page_url)->first();
            $active_categories_menu_ids = $current_category->getAncestorsAndSelf()->lists('id')->toArray();
            $breadcrumbs = Categories::leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
                ->select('categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name')
                ->where('categories_loc.lang', $lang)
                ->whereIn('categories.id',$active_categories_menu_ids)
                ->get();

            $products_ids = Products_categories::where('category_id',$current_category->id)->lists('product_id')->toArray();
            $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
                ->where('products_loc.lang',$lang)
                ->where('products.status',1)
                ->whereIn('products.id',$products_ids)
                ->where('products_images.main','=',1)
                ->where(function ($query) use($request,$products_ids_by_features){
                    if(count($request->checked) > 0)
                        $query->whereIn('products.id',$products_ids_by_features);
                    if($request->price_min)
                        $query->whereBetween('pricesite', [$request->price_min, $request->price_max]);
                })
                ->leftJoin('products_images','products_images.product_id','=','products.id')
                ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
                ->orderBy($sort,$order)
                ->paginate($paginate_count);

            $features_ids = Products_features::whereIn('product_id', $products_ids)
                ->leftJoin('features','features.id','=','products_features.feature_id')
                ->select('features.*')
                ->lists('id')
                ->toArray();

            $parentIds = Feature::whereIn('id', $features_ids)->get()->pluck('parent_id')->toArray();
            $features = Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
                ->where('features_loc.lang', 'ru')
                ->whereIn('features.id', array_merge($parentIds,$features_ids))
                ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
                ->get()->toHierarchy();

            $price_min = Products::whereIn('products.id',$products_ids)->min('pricesite');
            $price_max = Products::whereIn('products.id',$products_ids)->max('pricesite');
        }
        else {  /*Все катнгории*/
            $products_ids_by_features = [];
            if($request->checked){
                $products_ids_by_features = self::getProductsIdsByFeaturesIds($request->checked);
            }

            $products = Products::leftJoin('products_loc', 'products_loc.product_id', '=', 'products.id')
                ->where('products_loc.lang',$lang)
                ->where('products.status',1)
                ->where(function ($query) use($request,$products_ids_by_features){
                    if(count($request->checked) > 0)
                        $query->whereIn('products.id',$products_ids_by_features);
                    if($request->price_min)
                        $query->whereBetween('pricesite', [$request->price_min, $request->price_max]);
                })
                ->where('products_images.main','=',1)
                ->leftJoin('products_images','products_images.product_id','=','products.id')
                ->select('products.*','products_loc.lang','products_loc.name','products_loc.description','products_images.image')
                ->orderBy($sort,$order)
                ->paginate($paginate_count);

            /*для фильтров*/
            $products_ids = Products::lists('id')->toArray();
            $features_ids = Products_features::whereIn('product_id', $products_ids)
                ->leftJoin('features','features.id','=','products_features.feature_id')
                ->select('features.*')
                ->lists('id')
                ->toArray();

            $parentIds = Feature::whereIn('id', $features_ids)->get()->pluck('parent_id')->toArray();
            $features = Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
                ->where('features_loc.lang', 'ru')
                ->whereIn('features.id', array_merge($parentIds,$features_ids))
                ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
                ->get()->toHierarchy();

            $price_min = Products::min('pricesite');
            $price_max = Products::max('pricesite');

        }

        return view('frontend.catalog', [
            'current_page'                  => $page,
            'minPrice'                      => $price_min,
            'maxPrice'                      => $price_max,
            'features'                      => $features,
            'categories'                    => $categories,
            'products'                      => $products,
            'active_categories_menu_ids'    => isset($active_categories_menu_ids) ? $active_categories_menu_ids : [],
            'breadcrumbs'                   => isset($breadcrumbs) ? $breadcrumbs : []
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /*Заганяем в сессию вид отображения товаров*/
    public function setView(Request $request){
        $view = $request->view;
        Session::put('view',$view);
    }
}
