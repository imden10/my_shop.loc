<?php
namespace App;

use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Zizaco\Entrust\Traits\EntrustUserTrait;

use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use File;

class User extends Model implements AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        EntrustUserTrait // add this trait to your user model
    {
        EntrustUserTrait ::can insteadof Authorizable; //add insteadof avoid php trait conflict resolution
    }
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';


    /**
     * The attributes that are not mass assignable.
     *
     * @var array
     */
    protected $guarded = ['remember_token', 'persist_code', 'reset_password_code'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    public static function saveImage($request)
    {
        $image = $request->photo;
        $ext = $image->getClientOriginalExtension();
        $name = Carbon::now()->timestamp . '.' . $ext;
        if(!File::exists("uploads/")) {
            File::makeDirectory("uploads/");
        }
        if(!File::exists("uploads/users/")) {
            File::makeDirectory("uploads/users/");
        }
        $res = Image::make($image)->fit(200, 200)->save("uploads/users/" . $name);/*->fit(350, 200)*/
        if ($res){
            return $name;
        }
        else{
            return false;
        }
    }
}
