<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Image;
use File;

class Settings extends Model
{
	protected $table = 'settings';
	protected $guarded = [];
	public $timestamps = false;

	public static function saveLogo( $image ){

		$filename  = time() . '.' . $image->getClientOriginalExtension();

		$img = Image::make($image->getRealPath());

		$img->save( public_path('uploads/layout/' . $filename) );

		return $filename;
	}

}
