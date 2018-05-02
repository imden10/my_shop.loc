<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Page;
use Illuminate\Http\Request;
use Auth;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Settings;
use App\User;
use App\Models\Languages;
use App\Models\Categories;
use App;

class BaseController extends Controller
{

    public function __construct()
    {
        $settings = Settings::first();
        $lang = App::getLocale();
        $languages = Languages::all();
        $top_menu = Page::Join('page_loc', 'page_loc.page_id', '=', 'pages.id')
                        ->where('page_loc.lang',$lang)
                        ->select('pages.*','page_loc.name','page_loc.short_desc','page_loc.desc')
                        ->where('pages.active','1')
                        ->where('pages.type','main')
                        ->get()
                        ->toHierarchy();

        view()->share([
            'settings'      => $settings,
            'menu'          => $top_menu,
            'languages'     => $languages,
        ]);
    }

}