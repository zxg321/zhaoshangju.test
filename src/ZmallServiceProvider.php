<?php

namespace Zxg321\Zmall;

use Illuminate\Support\ServiceProvider;

class ZmallServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'zmall');
    }
    public function register()
    {
        # code...
    }
}
