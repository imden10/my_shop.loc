<?php

namespace App\Models;

use Baum\Node;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;
use File;

class Page extends Node
{
	protected $table = 'pages';
	protected $guarded = [];
	public $timestamps = false;

    public static function categories_tree(){

        $categories = self::all();

        foreach($categories as &$item) $categories_tree[$item->parent_id][] = &$item;
        unset($item);

        foreach($categories as &$item) if (isset($categories_tree[$item->id]))
            $item['subcategories'] = $categories_tree[$item->id];

        return reset( $categories_tree );
    }


    public static function get_parent_categories( $id ){

        $category = self::find( $id );

        if( isset($category->parent_id) && $category->parent_id != 0 ){
            array_push( self::$res, $category );
            self::get_parent_categories( $category->parent_id );
        }
        else
            array_push( self::$res, $category );

        return array_reverse(self::$res);
    }

    public static function saveImage($request)
    {
        $image = $request->image;
        $ext = $image->getClientOriginalExtension();
        $name = Carbon::now()->timestamp . '.' . $ext;
        if(!File::exists("uploads/")) {
            File::makeDirectory("uploads/");
        }
        if(!File::exists("uploads/pages/")) {
            File::makeDirectory("uploads/pages/");
        }
        $res = Image::make($image)->save("uploads/pages/" . $name);/*->fit(350, 200)*/
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
            $image = Page::whereId($id)->select('image')->first();
            $path = 'uploads/pages/';
            if($image->image != 'default.jpg'){
                if (File::exists($path.$image->image)) {
                    File::delete($path.$image->image);
                }
            }
        }
        parent::destroy( $ids );
    }

}
