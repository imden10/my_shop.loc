<?php

namespace App\Http\Controllers\Admin;

use App\Models\Feature;
use App\Models\Features_loc;
use Illuminate\Http\Request;
use App\Models\Languages;

use Session;

use App\Http\Requests;
use App\Http\Requests\FeatureCreate;

use App\Http\Controllers\Admin\AdminBaseController;

class AdminFeaturesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $features = json_encode(array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->whereIn('features_loc.lang', [$lang,'ru'])
            ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
            ->get()->toHierarchy()->toArray()));

        $languages = json_encode(Languages::select('name','lang as id')->get()->toArray());


        return view('admin.features.index', [
            'items'             => $features,
            'title'             => 'Фильтры',
            'languages'         => $languages
        ]);
    }

    public function createFeature(FeatureCreate $request){
        if($request->parent == 0){/*фильтр*/
            $name = 'Фильтр';
            $feature = Feature::create([
                'parent_id'     => null
            ]);
            Feature::whereId($feature->id)->update([
                'parent_id' => 0
            ]);
        }
        elseif($request->parent == 1) {/*Вариант*/
            $name = 'Вариант';
            $feature = Feature::create([
                'parent_id' => null
            ]);
            Feature::whereId($feature->id)->update([
                'parent_id' => (int)$request->filter
            ]);
        }
        if($feature){
            Features_loc::create([
                'feature_id'       => $feature->id,
                'lang'             => 'ru',
                'name'             => $request->name,
            ]);
        }
        return redirect()->back()->with('success',$name.' успешно добавлен!');
    }

    public function get_lang_features(Request $request){

        Session::put('alang',$request->lang);

        $features = json_encode(array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->whereIn('features_loc.lang', [$request->lang,'ru'])
            ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
            ->get()->toHierarchy()->toArray()));
        return $features;
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
        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $flag = Features_loc::whereLang($lang)->where('feature_id', $id)->first();
        if(!$flag){
            $lang = 'ru';
        }

        $features = json_encode(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->where('features_loc.lang', $lang)
            ->where('features.id', $id)
            ->select('features.id as id','features.parent_id','features_loc.name','features_loc.lang')
            ->first());

        $languages = Languages::select('name','lang as id')->get()->toArray();

        $title = json_decode($features)->parent_id > 0 ? 'Редактировать вариант' : 'Редактировать фильтр';

        return view('admin.features.edit', [
            'title'             => $title,
            'item'              => $features,
            'languages'         => json_encode($languages),
        ] );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function get_lang_feature_edit(Request $request){
//dd($request->all());
        Session::put('alang',$request->lang);

        $flag = Features_loc::whereLang($request->lang)->where('feature_id', $request->id)->first();
        if(!$flag){
            $lang = 'ru';
        }
        else {
            $lang = $flag->lang;
        }

        $item = json_encode(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
            ->where('features_loc.lang', $lang)
            ->where('features.id', $request->id)
            ->select('features.id as id','features.parent_id','features_loc.name','features_loc.lang')
            ->first());

        return $item;
    }

    public function updateFeaturePost(Request $request)
    {

        if($request->make == 'create'){/*Сохранение на новом языку*/
            $name_lang = Languages::whereLang($request->lang)->first()->name;
            $success = 'Создана копия на языку: '.$name_lang.'!';
            Features_loc::create([
                'feature_id'        => $request->id,
                'lang'              => $request->lang,
                'name'              => $request->name
            ]);
        }
        elseif($request->make == 'update'){/*Обновление на текущем языку*/
            $success = 'Фильтр успешно обновлен!';
            Features_loc::where('feature_id',$request->id)->where('lang',$request->lang)->update(array(
                'name'              => $request->name
            ));
        }
        return redirect()->back()->with('success',$success);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
//        dd($request->all());
        $checked = $request->checked;
        $child = Feature::whereIn('parent_id',$checked)->lists('parent_id')->toArray();
        $has_child = false;
        foreach ($checked as $check){
            if(in_array($check,$child))
                $has_child = true;
        }
        if ($has_child){
            $res = [
                'status'    => false,
                'error'     => 'Фильтр имеет варианты. Не возможно удалить Фильтр!'
            ];
            return json_encode($res);
        }
        if(count($checked) > 0){
            Feature::whereIn('id',$checked)->delete();

            if(!Session::has('alang'))
                $lang = 'ru';
            else
                $lang = Session::get('alang');

            $features = array_values(Feature::leftJoin('features_loc', 'features_loc.feature_id', '=', 'features.id')
                ->whereIn('features_loc.lang', [$lang,'ru'])
                ->select('features.id as id','features.parent_id','features.lft','features.rgt','features.depth','features_loc.name','features_loc.lang')
                ->get()->toHierarchy()->toArray());

            $res = [
                'status'            => true,
                'checked'           => $checked,
                'items'             => $features,
            ];
            return json_encode($res);
        }
    }
}
