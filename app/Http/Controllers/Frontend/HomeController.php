<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Frontend\BaseController;
use App\Models\Page;

use App\Jobs\Sitemapcreate;
use Queue;

class HomeController extends BaseController
{

    public function index()
    {
        $page = Page::whereSlug('/')->first();

        return view('frontend.home', [
            'current_page'       => $page
        ]);
    }

    public  function createSiteMap(){
        Queue::push(new Sitemapcreate());
        return 'Created';
    }

}
