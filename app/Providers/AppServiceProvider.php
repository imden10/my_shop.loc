<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Queue;
use App\Models\jobs_log;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Queue::after(function ($connection, $job, $data) {
            jobs_log::create([
                'connectionName'    => $connection,
                'job'               => $job,
                'data'              => $data
            ]);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
