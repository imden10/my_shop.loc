<?php

namespace App\Http\Controllers\Admin;

use App\Models\RoleUser;
use App\Role;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Admin\AdminBaseController;
use App\User;
use App\Http\Requests\AdminUserCreate;
use App\Http\Requests\AdminUserEdit;
use Input;
use Hash;
use File;

class AdminUsersController extends AdminBaseController
{

    public function index()
    {
        $users = User::leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('users.permissions', 'admin')
            ->leftJoin('roles', 'roles.id', '=', 'role_user.role_id')
            ->select('users.*', 'roles.display_name as role_name')
            ->get();

        return view('admin.users.users', [
            'title' => 'Пользователи',
            'items' => $users
        ]);
    }

    public function create()
    {
        return view('admin.users.userCreate', [
            'title' => 'Создание нового пользователя',
            'item' => new User(),
            'roles' => Role::all()
        ]);
    }

    public function store(AdminUserCreate $request)
    {
        $photo = 'noimage.jpg';
        if ($request->photo){
            $photo = User::saveImage($request);
        }
        $user = User::create([
            'name' => $request->name,
            'photo' => $photo,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'activated' => 1,
            'permissions' => 'admin'
        ]);
        if ($user) {
            RoleUser::create([
                'user_id' => $user->id,
                'role_id' => $request->role,
            ]);
            return redirect('/master/users/users')->with('success', 'Пользователь успешно добавлен!');
        }
    }

    public function edit($id)
    {
        $user = User::leftJoin('role_user', 'role_user.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->select('users.*', 'role_user.role_id as role')
            ->first();

        return view('admin.users.userEdit',[
            'title'             => 'Редактирование пользователя',
            'user'              => $user,
            'roles'             => Role::all()
        ]);
    }

    public function update(AdminUserEdit $request, $id)
    {
//        dd($id,$request->all());
        $old_password = User::whereId($id)->first()->password;/*Старый пароль с базы*/
        if ($request->password_confirmation){/*Если ввели пароль*/
            if (Hash::check($request->password,$old_password)){
                $new_pass = Hash::make($request->password_confirmation);
            }
            else {
                return redirect()->back()->with('error','Вы ввели не верный пароль!');
            }
        }
        else {
            $new_pass = $old_password;
        }
        $photo = '';
        if ($request->photo){
            $photo = User::whereId($id)->select('photo')->first();
            $path = 'uploads/users/';
            if ($photo->photo != 'noimage.jpg') {
                if (File::exists($path . $photo->photo)) {
                    File::delete($path . $photo->photo);
                }
            }
            $photo = User::saveImage($request);
            User::whereId($id)->update([
                'photo'      => $photo
            ]);
        }
        $user = User::whereId($id)->update([
            'name'          => $request->name,
            'password'      => $new_pass
        ]);
        if($user || $photo){
            RoleUser::where('user_id',$id)->update ([
                'role_id' => $request->role,
            ]);
            return redirect()->back()->with('success', 'Пользователь успешно обновлен!');
        }
    }

    public function destroy(Request $request)
    {
        $checked = $request->checked;
        $images = User::whereIn('id',$checked)->select('photo')->get();
        if ($images){
            $path = 'uploads/users/';
            foreach ($images as $image){
                if($image->photo != 'noimage.jpg'){
                    if (File::exists($path.$image->photo)){
                        File::delete($path.$image->photo);
                    }
                }
            }
        }
        User::whereIn('id', $checked)->delete();
        $result = [
            'status' => true,
            'checked' => $checked
        ];
        echo json_encode($result);
    }
}
