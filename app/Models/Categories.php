<?php

namespace App\Models;

use Baum\Node;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use File;

class Categories extends Node
{
    protected $table = 'categories';
    protected $guarded = [];

    public static function saveImage($request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $name = Carbon::now()->timestamp . '.' . $ext;
        if(!File::exists("uploads/")) {
            File::makeDirectory("uploads/");
        }
        if(!File::exists("uploads/categories/")) {
            File::makeDirectory("uploads/categories/");
        }
        $res = Image::make($image)->save("uploads/categories/" . $name);/*->fit(350, 200)*/
        if ($res){
            return $name;
        }
        else{
            return false;
        }
    }

    public static function deleteImage( $ids ){
        /*Удаляем старую картинку*/
        foreach ($ids as $id){
            $image = Categories::whereId($id)->select('image')->first();
            $path = 'uploads/categories/';
            if($image->image != 'noimage.jpg'){
                if (File::exists($path.$image->image)) {
                    File::delete($path.$image->image);
                }
            }
        }
        parent::destroy( $ids );
    }
}
