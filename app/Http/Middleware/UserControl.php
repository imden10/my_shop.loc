<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Contracts\Auth\Guard;

class UserControl
{

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user() !== null){
            if (Auth::user()->permissions == 'user') {
                return $next($request);
            }
            else {
                dd("Вы никак не пользователь!");
            }
        }
    else {
            dd("Вы никак не пользователь!");
        }
    }
}
