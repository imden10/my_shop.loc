<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Ads;
use App\Models\Page;
use App\Models\News;
use App\Models\user_info;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Frontend\BaseController;
use Input;

class SearchController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $result = false;
        $ads = [];
        $news = [];
        $company = [];
        if ( Input::has('search') ){
            $search = Input::get('search');
            $type = Input::get('type');
            if($type == 'main'){/*Поиск по всему*/
                $company = user_info::where(function($query) use ($search)
                {
                    $query->where('company_name','like', '%'.$search.'%');
                })->get();
                $ads = Ads::where(function($query) use ($search)
                {
                    $query->where('author','user')
                          ->where('name','like', '%'.$search.'%');
                })->get();
                $news = News::where(function($query) use ($search)
                {
                    $query->where('author','user')
                          ->where('name','like', '%'.$search.'%');
                })->get();
                if (count($company) > 0 || count($ads) > 0 || count($news) > 0){
                    $result = true;
                }
            }
            elseif($type == 'company'){/*Поиск по компаниям*/
                $company = user_info::where(function($query) use ($search)
                {
                    $query->where('company_name','like', '%'.$search.'%');
                })->get();
                if (count($company) > 0 ){
                    $result = true;
                }
            }
            elseif($type == 'ads'){/*Поиск по объявлениям*/
                $ads = Ads::where(function($query) use ($search)
                {
                    $query->where('author','user')
                          ->where('name','like', '%'.$search.'%');
                })->get();
                if (count($ads) > 0 ){
                    $result = true;
                }
            }
        }

        return view('frontend.show-search',[
            'current_page'  => new Page(),
            'search'        => $search,
            'company'       => $company,
            'ads'           => $ads,
            'news'          => $news,
            'result'        => $result,
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
}
