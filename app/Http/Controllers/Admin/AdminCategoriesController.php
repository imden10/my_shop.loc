<?php

namespace App\Http\Controllers\Admin;

use App\Models\Categories;
use App\Models\Categories_feature;
use App\Models\Categories_loc;
use App\Models\Features_loc;
use Illuminate\Http\Request;
use App\Models\Languages;
use App\Models\Feature;

use App\Http\Requests\CategoriesCreate;
use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use File;
use Session;

class AdminCategoriesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getIndex(){

        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $categories = json_encode(array_values( Categories::select(['categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name'])
            ->leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
            ->whereIn('categories_loc.lang', [$lang,'ru'])
            ->get()->toHierarchy()->toArray() ));
        $count_categories = Categories::count();

        $languages = Languages::select('name','lang as id')->get()->toArray();

        return view('admin.categories.show', [
            'categories'        => $categories,
            'title'             => 'Категории',
            'count_categories'  => $count_categories,
            'languages'         => json_encode($languages)
        ]);
    }

    public function get_lang_categories(Request $request){

        Session::put('alang',$request->lang);

        $categories = json_encode(array_values( Categories::select(['categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name','categories_loc.lang'])
            ->leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
            ->whereIn('categories_loc.lang', [$request->lang,'ru'])
            ->get()->toHierarchy()->toArray() ));
        return $categories;
    }

    public function postIndex( Request $request ) {

        $ids = $request->get('check');
        // удаляем
        if ($request->get('action') == 'delete') {
            Categories::destroy($ids);
        } // обновляем позиции
        else if ($request->get('action') == 'rebuild') {
            Categories::rebuildTree($request->get('data'));
            return 'rebuilded';
        }
        return redirect()->back();
    }


    public function createCategories() {
        $categories = Categories::leftJoin('categories_loc','categories_loc.cat_id','=','categories.id')
                        ->where('categories.depth',0)
                        ->where('categories_loc.lang','ru')
                        ->select('categories.id as id','categories_loc.name')
                        ->get();

        $features = json_encode(array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->where('features_loc.lang', 'ru')
            ->where('features.parent_id', 0)
            ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
            ->get()->toHierarchy()->toArray()));

        return view('admin.categories.create', [
            'title'         => 'Новая категория',
            'category'      => new Categories(),
            'categories'    => $categories,
            'features'      => $features
        ]);
    }

    public function createCategoriesPost( CategoriesCreate $request)
    {
//        dd($request->all());
        $active = $request->has('active') ? '1' : '0';
        $image = 'noimage.jpg';
        if ($request->image){
            $image = Categories::saveImage($request);
        }
        $category = Categories::create([
            'parent_id'     => $request->parent_id != '0' ? $request->parent_id : null,
            'slug'          => $request->slug,
            'status'        => $active,
            'image'         => $image
        ]);
        if($category){
            //Создаем только русскую версию, по умолчанию
            Categories_loc::create([
                'cat_id'            => $category->id,
                'lang'              => 'ru',/*При создании - по умолчанию*/
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_keys'         => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
            if($request->has('features')){/*если есть фильтра*/
                foreach ($request->features as $feature){
                    Categories_feature::create([
                        'category_id'   => $category->id,
                        'feature_id'    => $feature
                    ]);
                }
            }
        }
        return redirect()->back()->with('success','Категория создана!');
    }

    public function editCategories( $id ) {

        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $flag = Categories_loc::whereLang($lang)->where('cat_id', $id)->first();
        if(!$flag){
            $lang = 'ru';
        }

        $category = json_encode(
            Categories::leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
                ->where('categories_loc.lang', '=', $lang)
                ->where('categories.id', $id)
                ->select('categories.id as id', 'categories.status', 'categories.image', 'categories.slug', 'categories_loc.name','categories_loc.lang', 'categories_loc.description','categories_loc.meta_title','categories_loc.meta_keys','categories_loc.meta_description')
                ->first());

        $features = array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->where('features_loc.lang', Session::get('alang'))
            ->where('features.parent_id', 0)
            ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
            ->get()->toHierarchy()->toArray());

        if(count($features) == 0){
            $features = array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
                ->where('features_loc.lang', 'ru')
                ->where('features.parent_id', 0)
                ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
                ->get()->toHierarchy()->toArray());
        }

        $cat_features = json_encode(Categories_feature::where('category_id',$id)->lists('feature_id')->toArray());

        $languages = Languages::select('name','lang as id')->get()->toArray();

        return view('admin.categories.edit', [
            'title'             => 'Редактировать категорию',
            'category'          => $category,
            'languages'         => json_encode($languages),
            'features'          => json_encode($features),
            'cat_features'      => $cat_features,
        ] );
    }

    public function get_lang_categories_edit(Request $request){
//dd($request->all());
        Session::put('alang',$request->lang);

        $flag = Categories_loc::whereLang($request->lang)->where('cat_id', $request->id)->first();
        if(!$flag){
            $lang = 'ru';
        }
        else {
            $lang = $flag->lang;
        }

        $category = Categories::leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
                ->where('categories_loc.lang', '=', $lang)
                ->where('categories.id', $request->id)
                ->select('categories.id as id', 'categories.status', 'categories.image', 'categories.slug', 'categories_loc.name','categories_loc.lang', 'categories_loc.description','categories_loc.meta_title','categories_loc.meta_keys','categories_loc.meta_description')
                ->first();

        $features = Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->where('features_loc.lang', $request->lang)
            ->where('features.parent_id', 0)
            ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
            ->get();

        if(count($features) == 0){
            $features = Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
                ->where('features_loc.lang', 'ru')
                ->where('features.parent_id', 0)
                ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
                ->get();
        }

        $res = [
            'category'  => $category,
            'features'  => $features
        ];

        return json_encode($res);
    }

    public function updateCategoriesPost( Request $request)
    {
//        dd($request->all());
        $active = $request->has('active') ? '1' : '0';
        $category = Categories::whereId($request->id)->update([
            'status'    => $active
        ]);

        if($request->has('slug')){
            $category = Categories::whereId($request->id)->update([
                'slug'    => $request->slug
            ]);
        }

        Categories_feature::where('category_id',$request->id)->delete();
        if($request->has('features')){/*если есть фильтра*/
            foreach ($request->features as $feature){
                Categories_feature::create([
                    'category_id'   => $request->id,
                    'feature_id'    => $feature
                ]);
            }
        }

        if ($request->image) {
            /*Удаляем старую картинку*/
            $image = Categories::whereId($request->id)->select('image')->first();
            $path = 'uploads/categories/';
            if (File::exists($path.$image->image)) {
                File::delete($path.$image->image);
            }
            /*Создаем новую*/
            $new_image = Categories::saveImage($request);
            if ($new_image){
                Categories::whereId($request->id)->update(['image' => $new_image]);
            }
        }

        if($request->make == 'create'){/*Сохранение категории на новом языку*/
            $name_lang = Languages::whereLang($request->lang)->first()->name;
            $success = 'Создана копия категории на языку: '.$name_lang.'!';
            Categories_loc::create([
                'cat_id'            => $request->id,
                'lang'              => $request->lang,
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_keys'         => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
        }
        elseif($request->make == 'update'){/*Обновление на текущем языку*/
            $success = 'Категория успешно обновлена!';
            Categories_loc::where('cat_id',$request->id)->where('lang',$request->lang)->update([
                'name'              => $request->name,
                'description'       => $request->description,
                'meta_title'        => $request->meta_title,
                'meta_keys'         => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
        }
        return redirect()->back()->with('success',$success);
    }

    public function delete(Request $request)
    {
//        dd($request->all());
        $checked = $request->checked;
        $child = Categories::whereIn('parent_id',$checked)->lists('parent_id')->toArray();
        $has_child = false;
        foreach ($checked as $check){
            if(in_array($check,$child))
                $has_child = true;
        }
        if ($has_child){
            $res = [
                'status'    => false,
                'error'     => 'Категория имеет подкатегории. Не возможно удалить категорию!'
            ];
            return json_encode($res);
        }
        if(count($checked) > 0){
            Categories::deleteImage($checked);
            Categories::whereIn('id',$checked)->delete();

            if(!Session::has('alang'))
                $lang = 'ru';
            else
                $lang = Session::get('alang');

            $categories = array_values( Categories::select(['categories.id', 'categories.parent_id', 'categories.lft', 'categories.rgt', 'categories.depth', 'categories.slug', 'categories_loc.name'])
                ->leftJoin('categories_loc', 'categories.id', '=', 'categories_loc.cat_id')
                ->where('categories_loc.lang', '=', $lang)
                ->get()->toHierarchy()->toArray());

            $res = [
                'status'            => true,
                'checked'           => $checked,
                'items'             => $categories,
            ];
            return json_encode($res);
        }
    }

}
