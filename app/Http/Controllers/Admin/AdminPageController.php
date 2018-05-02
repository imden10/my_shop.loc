<?php

namespace App\Http\Controllers\Admin;

use App\Models\Languages;
use Illuminate\Http\Request;

use App\Models\Page;
use App\Models\Page_loc;
use App\Http\Requests;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Admin\AdminBaseController;
use File;
use Session;

class AdminPageController extends AdminBaseController
{

	public function getIndex($page_type){

        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $pages = json_encode(array_values( Page::select(['pages.id', 'pages.parent_id', 'pages.lft', 'pages.rgt', 'pages.depth', 'pages.slug', 'page_loc.name', 'pages.type','pages.constant'])
            ->leftJoin('page_loc', 'pages.id', '=', 'page_loc.page_id')
            ->where('pages.type', '=', $page_type)
            ->whereIn('page_loc.lang', [$lang,'ru'])
            ->get()->toHierarchy()->toArray() ));
//        dd($pages);
        $count_pages = Page::where('type',$page_type)->count();

        $languages = Languages::select('name','lang as id')->get()->toArray();

		return view('admin.pages.show', [
		    'pages'         => $pages,
            'title'         => $page_type == 'main' ? 'Основные страницы' : 'Дополнительные страницы',
            'page_type'     => $page_type,
            'count_pages'   => $count_pages,
            'languages'     => json_encode($languages)
        ]);
	}

    public function get_lang_pages(Request $request){

        Session::put('alang',$request->lang);

        $pages = json_encode(array_values( Page::select(['pages.id', 'pages.parent_id', 'pages.lft', 'pages.rgt', 'pages.depth', 'pages.slug', 'page_loc.name', 'pages.type','pages.constant'])
            ->leftJoin('page_loc', 'pages.id', '=', 'page_loc.page_id')
            ->where('pages.type', '=', $request->page_type)
            ->whereIn('page_loc.lang', [$request->lang,'ru'])
//            ->orwhere('page_loc.lang', '=', 'ru')/*если нету языка, то по умолчанию*/
            ->get()->toHierarchy()->toArray() ));
        return $pages;
    }

    public function postIndex( Request $request ) {

        $ids = $request->get('check');
        // удаляем
        if ($request->get('action') == 'delete') {
            Page::destroy($ids);
        } // обновляем позиции
        else if ($request->get('action') == 'rebuild') {
            Page::rebuildTree($request->get('data'));
            return 'rebuilded';
        }
        return redirect()->back();
    }

 
    public function createPage($page_type) {
        return view('admin.pages.create', [
            'title'       => 'Новая страница',
            'page'        => new Page(),
            'page_type'   => $page_type
        ]);
    }

    public function createPagePost( PageRequest $request)
    {
//        dd($request->all());
        $active = $request->has('active') ? '1' : '0';
        $image = 'default.jpg';
        if ($request->image){
            $image = Page::saveImage($request);
        }
        $page = Page::create([
            'slug'      => $request->slug,
            'type'      => $request->type,
            'active'    => $active,
            'image'     => $image
        ]);
        if($page){
            //Создаем только русскую версию, по умолчанию
            Page_loc::create([
                'page_id'           => $page->id,
                'lang'              => 'ru',/*При создании - по умолчанию*/
                'name'              => $request->name,
                'desc'              => $request->desc,
                'meta_title'        => $request->meta_title,
                'meta_keywords'     => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
        }
        return redirect()->back()->with('success','Страница создана!');
    }

	public function editPage( $page_type, $id ) {

        if(!Session::has('alang'))
            $lang = 'ru';
        else
            $lang = Session::get('alang');

        $flag = Page_loc::whereLang($lang)->where('page_id', $id)->first();
        if(!$flag){
            $lang = 'ru';
        }

        $page = json_encode(
            Page::leftJoin('page_loc', 'pages.id', '=', 'page_loc.page_id')
            ->where('page_loc.lang', '=', $lang)
            ->where('pages.type', '=', $page_type)
            ->where('pages.id', $id)
            ->select('pages.type', 'pages.constant', 'pages.id as id', 'pages.active', 'pages.image', 'pages.slug', 'page_loc.name','page_loc.lang', 'page_loc.desc','page_loc.meta_title','page_loc.meta_keywords','page_loc.meta_description')
            ->first());

        $languages = Languages::select('name','lang as id')->get()->toArray();

		return view('admin.pages.edit', [
		    'title'       => 'Редактировать страницу',
            'page'        => $page,
            'page_type'   => $page_type,
            'languages'     => json_encode($languages),
        ] );
	}

    public function get_lang_pages_edit(Request $request){
//dd($request->all());
        Session::put('alang',$request->lang);

        $flag = Page_loc::whereLang($request->lang)->where('page_id', $request->id)->first();
        if(!$flag){
            $lang = 'ru';
        }
        else {
            $lang = $flag->lang;
        }

        $page = json_encode(
            Page::leftJoin('page_loc', 'pages.id', '=', 'page_loc.page_id')
                ->where('page_loc.lang', '=', $lang)
                ->where('pages.type', '=', $request->page_type)
                ->where('pages.id', $request->id)
                ->select('pages.type', 'pages.constant', 'pages.id as id', 'pages.active', 'pages.image', 'pages.slug', 'page_loc.name','page_loc.lang', 'page_loc.desc','page_loc.meta_title','page_loc.meta_keywords','page_loc.meta_description')
                ->first());

        return $page;
    }

    public function updatePagePost( Request $request)
    {
//        dd($request->all());
        $active = $request->has('active') ? '1' : '0';
        $page = Page::whereId($request->id)->update([
            'active'    => $active
        ]);

        if($request->has('slug')){
            $page = Page::whereId($request->id)->update([
                'slug'    => $request->slug
            ]);
        }

        if ($request->image) {
            /*Удаляем старую картинку*/
            $image = Page::whereId($request->id)->select('image')->first();
            $path = 'uploads/pages/';
            if (File::exists($path.$image->image)) {
                File::delete($path.$image->image);
            }
            /*Создаем новую*/
            $new_image = Page::saveImage($request);
            if ($new_image){
                Page::whereId($request->id)->update(['image' => $new_image]);
            }
        }

        if($request->make == 'create'){/*Сохранение страницы на новом языку*/
            $name_lang = Languages::whereLang($request->lang)->first()->name;
            $success = 'Создана копия страницы на языку: '.$name_lang.'!';
            Page_loc::create([
                'page_id'           => $request->id,
                'lang'              => $request->lang,
                'name'              => $request->name,
                'desc'              => $request->desc,
                'meta_title'        => $request->meta_title,
                'meta_keywords'     => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
        }
        elseif($request->make == 'update'){/*Обновление на текущем языку*/
            $success = 'Страница успешно обновлена!';
            Page_loc::where('page_id',$request->id)->where('lang',$request->lang)->update([
                'name'              => $request->name,
                'desc'              => $request->desc,
                'meta_title'        => $request->meta_title,
                'meta_keywords'     => $request->meta_keywords,
                'meta_description'  => $request->meta_description
            ]);
        }
        return redirect()->back()->with('success',$success);
    }

    public function delete(Request $request)
    {
//        dd($request->all());
        $checked = $request->checked;
        $child = Page::whereIn('parent_id',$checked)->lists('parent_id')->toArray();
        $has_child = false;
        foreach ($checked as $check){
            if(in_array($check,$child))
                $has_child = true;
        }
        if ($has_child){
            $res = [
                'status'    => false,
                'error'     => 'Страница имеет подстраницы. Не возможно удалить страницу!'
            ];
            return json_encode($res);
        }
        if(count($checked) > 0){
            Page::deleteImage($checked);
            Page::whereIn('id',$checked)->delete();

            if(!Session::has('alang'))
                $lang = 'ru';
            else
                $lang = Session::get('alang');

            $pages = array_values( Page::select(['pages.id', 'pages.parent_id', 'pages.lft', 'pages.rgt', 'pages.depth', 'pages.slug', 'page_loc.name', 'pages.type','pages.constant'])
                ->leftJoin('page_loc', 'pages.id', '=', 'page_loc.page_id')
                ->where('page_loc.lang', '=', $lang)
                ->where('pages.type', '=', $request->page_type)
                ->get()->toHierarchy()->toArray() );

            $res = [
                'status'    => true,
                'checked'   => $checked,
                'items'     => $pages,
            ];
            return json_encode($res);
        }
    }

}
