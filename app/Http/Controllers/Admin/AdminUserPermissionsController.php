<?php

namespace App\Http\Controllers\Admin;

use App\Models\PermissionRole;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UserPermissionCreate;
use App\Http\Controllers\Admin\AdminBaseController;

class AdminUserPermissionsController extends AdminBaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.users.user-permissions',[
            'title'     => 'Группы пользователей',
            'items'     => Role::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.users.userPermissionCreate',[
            'title'     => 'Создание новой группы пользователей',
            'item'      => new Role()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserPermissionCreate $request)
    {
        $input = $request->except('_token');
        $role = Role::create($input);
        if ($role){
            return redirect("/master/users/users-permissions")->with('success','Новая группа успешно добавлена!');
        }
        else {
            return redirect()->back()->with('error','Произошла непридвиденная ошибка!');
        }
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
        return view('admin.users.userPermissionEdit',[
            'title'             => 'Редактирование группы пользователей',
            'role'              => Role::whereId($id)->first(),
            'permissions'       => Permission::all(),
            'permissions_role'  => PermissionRole::where('role_id',$id)->lists('permission_id')->toArray()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPermissionCreate $request, $id)
    {
//        dd($id,$request->all());
        $role = Role::whereId($id)->update($request->except(['_token','_method','check']));
        if ($role){
            $ids = $request->check;
            PermissionRole::where('role_id',$id)->delete();
            if($ids){
                foreach ($ids as $item){
                    PermissionRole::create([
                        'role_id'         => $id,
                        'permission_id'   => $item,
                    ]);
                }
            }
            return redirect()->back()->with('success','Группа пользователей успешно обновлена!');
        }
        else{
            return redirect()->back()->with('error','Произошла непредвиденная ошибка!');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $checked = $request->checked;
        Role::whereIn('id', $checked)->delete();
        $result = [
            'status' => true,
            'checked' => $checked
        ];
        echo json_encode($result);
    }
}
