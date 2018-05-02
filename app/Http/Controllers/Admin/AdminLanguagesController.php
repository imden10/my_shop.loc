<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use App\Models\Languages;
use App\Http\Requests\LanguagesCreate;

class AdminLanguagesController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function getLanguages(){
        $languages = Languages::all();
        return view('admin.settings.languages', [
            'title'     => 'Локализация',
            'items'     => $languages
        ]);
    }

    public function postCreate(LanguagesCreate $request)
    {
        $input = $request->except(['_token']);
        Languages::create($input);
        return redirect()->back()->with('success','Язык успешно добавлен!');
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
    public function postUpdate(Request $request)
    {
        $id = $request->id;
        Languages::where('id',$id)->update([
            'name' => $request->name
        ]);
        $result = [
            'status' => true,
            'id' => $id
        ];
        echo json_encode($result);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function postDestroy(Request $request)
    {
        $checked = $request->check;
        Languages::whereIn('id', $checked)->delete();
        $result = [
            'status' => true,
            'checked' => $checked
        ];
        echo json_encode($result);
    }
}
