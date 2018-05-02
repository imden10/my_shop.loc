<?php

namespace App\Http\Controllers\Frontend;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Page;
use App;

class PageController extends BaseController
{
    public function index($page_url)
    {
        $lang = App::getLocale();
        $page = Page::Join('page_loc', 'page_loc.page_id', '=', 'pages.id')
            ->where('page_loc.lang',$lang)
            ->where('pages.slug',$page_url)
            ->select('pages.*','page_loc.name','page_loc.short_desc','page_loc.desc')
            ->where('pages.active','1')
            ->first();

        if (count($page) > 0) {
                return view('frontend.show-page', [
                    'current_page' => $page
                ]);
        }
        else {
            return view('errors.404', [
                'current_page' => new Page()
            ]);
        }

    }

}
